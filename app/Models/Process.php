<?php

namespace App\Models;

use App\Support\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Process extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'created_at';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 50;

    const STORAGE_EXCEL_TEMPLATE_PATH = 'app/excel/templates/vps.xlsx';
    const STORAGE_EXCEL_EXPORT_PATH = 'app/excel/exports/vps';

    protected $guarded = ['id'];

    protected $with = [
        'countryCode',
        'status',
        'owners',
        'crbeCountries',
        'currency',
        'promoCompany',
        'lastComment',
    ];

    // ********** Events **********
    protected static function booted(): void
    {
        static::creating(function ($item) {
            // disabled because old data is being added
            // uncomment after all old data add finished
            // $item->status_update_date = now();
            $item->status_update_date = $item->date;  // remove after old data add finished
            $item->synchronizeGenericColumnsUpdate();
        });

        static::created(function ($item) {
            $item->validateDaysPast();
            $item->validateStageTwoStartDate();
            $item->validatePriceInUSD();
            $item->validateIncreasedPriceAfterCreate();
            $item->addStatusUpdateHistoryAfterCreate();
        });

        static::updating(function ($item) {
            // disabled because old data is being added
            // uncomment after all old data add finished
            // $item->validateStatusUpdateDate();
            $item->status_update_date = $item->date;  // remove after old data add finished
            $item->synchronizeGenericColumnsUpdate();
            $item->validateIncreasedPriceOnUpdating();

            if ($item->isDirty('status_id')) {
                $item->addStatusUpdateHistoryonUpdating();
            }
        });

        static::updated(function ($item) {
            $item->validateDaysPast();
            $item->validateStageTwoStartDate();
            $item->validatePriceInUSD();
        });

        static::restoring(function ($item) {
            if ($item->generic->trashed()) {
                $item->generic->restoreQuietly();
            }

            if ($item->manufacturer->trashed()) {
                $item->manufacturer->restoreQuietly();
            }
        });

        static::forceDeleting(function ($item) {
            $item->owners()->detach();
            $item->crbeCountries()->detach();

            foreach ($item->comments as $comment) {
                $comment->delete();
            }

            foreach ($item->histories as $history) {
                $history->delete();
            }
        });
    }

    // ********** Relations **********
    public function generic()
    {
        return $this->belongsTo(Generic::class)->withTrashed();
    }

    public function manufacturer()
    {
        return $this->hasOneThrough(
            Manufacturer::class,
            Generic::class,
            'id', // Foreign key on the Generic table
            'id', // Foreign key on the Manufacturer table
            'generic_id', // Local key on the Process table
            'manufacturer_id' // Local key on the Generic table
        )->withTrashedParents()->withTrashed();
    }

    public function countryCode()
    {
        return $this->belongsTo(CountryCode::class);
    }

    public function status()
    {
        return $this->belongsTo(ProcessStatus::class, 'status_id');
    }

    public function owners()
    {
        return $this->belongsToMany(ProcessOwner::class, 'process_processowners', 'process_id', 'owner_id');
    }

    public function crbeCountries()
    {
        return $this->belongsToMany(Country::class, 'process_crbecountry', 'process_id', 'country_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function promoCompany()
    {
        return $this->belongsTo(PromoCompany::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function lastComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }

    public function histories()
    {
        return $this->hasMany(ProcessHistory::class);
    }

    public function statusUpdates()
    {
        return $this->hasMany(ProcessHistory::class)
            ->where('action', ProcessHistory::STATUS_UPDATE_ACTION_NAME)
            ->orderBy('id', 'desc');
    }

    public function latestStatusUpdate()
    {
        return $this->hasOne(ProcessHistory::class)
            ->where('action', ProcessHistory::STATUS_UPDATE_ACTION_NAME)
            ->latestOfMany();
    }

    // ********** Querying **********
    public function scopeWithRelations($query)
    {
        return $query->with([
            'generic' => function ($query) {
                $query->select('id', 'manufacturer_id', 'mnn_id', 'category_id', 'form_id', 'dose', 'pack', 'minimum_volume', 'expiration_date_id')
                    ->withOnly(['mnn', 'category', 'form', 'expirationDate', 'zones']);
            },

            'manufacturer' => function ($query) {
                $query->select('manufacturers.id', 'manufacturers.name', 'manufacturers.category_id', 'manufacturers.country_id', 'manufacturers.bdm_user_id', 'manufacturers.analyst_user_id')
                    ->withOnly([
                        'category',
                        'country',
                        'bdm' => function ($query) {
                            $query->select('id', 'name', 'photo')
                                ->withOnly([]);
                        },
                        'analyst' => function ($query) {
                            $query->select('id', 'name', 'photo')
                                ->withOnly([]);
                        },
                    ]);
            }
        ]);
    }

    public static function getItemsFinalized($params, $items = null, $finaly = 'paginate')
    {
        $items = $items ?: self::query();
        $items = self::filter($items);
        $items = self::additionalFilterByRoles($items);
        $items = self::additionalStatusFilterByRoles($items);
        $items = self::finalize($params, $items, $finaly);

        return $items;
    }

    private static function filter($items)
    {
        $whereColumns = [
            'id',
            'country_code_id',
            'promo_company_id',
        ];

        $whereDateRangeColumns = [
            'date',
            'created_at',
            'updated_at',
        ];

        $whereLikeColumns = [
            'trademark_en',
            'trademark_ru',
        ];

        $whereRelationColumns = [
            [
                'relationName' => 'generic',
                'name' => 'mnn_id',
            ],

            [
                'relationName' => 'generic',
                'name' => 'form_id',
            ],

            [
                'relationName' => 'generic',
                'name' => 'dose',
            ],

            [
                'relationName' => 'generic',
                'name' => 'pack',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'analyst_user_id',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'bdm_user_id',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'country_id',
            ],
        ];

        $whereRelationAmbigiousColumns = [
            [
                'relationName' => 'manufacturer',
                'name' => 'manufacturer_id',
                'ambigiousNme' => 'manufacturers.id',
            ],

            [
                'relationName' => 'generic',
                'name' => 'generic_category_id',
                'ambigiousNme' => 'generics.category_id',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'manufacturer_category_id',
                'ambigiousNme' => 'manufacturers.category_id',
            ],
        ];

        $belongsToManyRelations = [
            'owners',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereLikeColumns($items, $whereLikeColumns);
        $items = Helper::filterWhereRelationColumns($items, $whereRelationColumns);
        $items = Helper::filterWhereRelationAmbigiousColumns($items, $whereRelationAmbigiousColumns);
        $items = Helper::filterBelongsToManyRelations($items, $belongsToManyRelations);
        $items = Helper::filterWhereDateRangeColumns($items, $whereDateRangeColumns);

        return $items;
    }

    /**
     * Get only analysts added processes for simple users (not admin & not moderators)
     */
    public static function additionalFilterByRoles($items)
    {
        $user = request()->user();

        if (!$user->isAdminOrModerator()) {
            $items = $items->whereHas('manufacturer', function ($query) use ($user) {
                $query->where('analyst_user_id', $user->id);
            });
        }

        return $items;
    }

    /**
     * Return all processes with status stage >= 5 for analysts
     * while status_id >= 5 is requested,
     * because filtering processes with status stage > 5
     * are available only for admins
     *
     * else filter simple where status_id
     */
    public static function additionalStatusFilterByRoles($items)
    {
        $statusID = request()->input('status_id');

        if (!$statusID) return $items;

        $user = request()->user();
        $parentStatusID = ProcessStatus::find($statusID)->parent->id;

        if (!$user->isAdmin() && $parentStatusID >= 5) {
            $items = $items->whereHas('status.parent', function ($query) {
                $query->where('stage', '>=', 5);
            });
        } else {
            $items = $items->where('status_id', $statusID);
        }

        return $items;
    }

    private static function finalize($params, $items, $finaly)
    {
        $items = $items
            ->withRelations()
            ->orderBy($params['orderBy'], $params['orderType'])
            ->orderBy('id', $params['orderType']);

        switch ($finaly) {
            case 'paginate':
                $items = $items
                    ->paginate($params['paginationLimit'], ['*'], 'page', $params['currentPage'])
                    ->appends(request()->except('page'));
                break;

            case 'get':
                $items = $items->get();
                break;
        }

        return $items;
    }

    // ********** Miscellaneous **********
    public function getAllComments()
    {
        return $this->comments()->latest()->get();
    }

    public function loadComments()
    {
        return $this->load(['comments' => function ($query) {
            $query->orderBy('id', 'desc');
        }]);
    }

    private function storeComment($comment)
    {
        if (!$comment) return;

        $this->comments()->save(
            new Comment(['body' => $comment, 'user_id' => request()->user()->id, 'created_at' => now()]),
        );
    }

    /**
     * Used in Kernel for updating
     * days_past and manufacturer_followed_offered_price_in_usd
     * via chron every day.
     */
    public static function updateDailyAttributes()
    {
        self::all()->each(function ($item) {
            $item->validateDaysPast();
            $item->validatePriceInUSD();
        });
    }

    public static function createFromRequest($request)
    {
        $countryCodeIDs = $request->input('country_code_ids');

        foreach ($countryCodeIDs as $countryCodeID) {
            $countryCode = CountryCode::find($countryCodeID);

            $item = new self($request->all());
            $item->country_code_id = $countryCode->id;

            // For each country codes used seperately year inputs
            // following pattern year_[1-3]_countryCodeName
            $item->year_1 = $request->input('year_1_' . $countryCode->name);
            $item->year_2 = $request->input('year_2_' . $countryCode->name);
            $item->year_3 = $request->input('year_3_' . $countryCode->name);
            $item->save();

            // BelongsToMany relations
            $item->owners()->attach($request->input('owners'));
            $item->crbeCountries()->attach($request->input('crbeCountries'));

            // HasMany relations
            $item->storeComment($request->comment);

            // increment country code usage count for prioritizing
            $countryCode->usage_count = $countryCode->usage_count + 1;
            $countryCode->save();
        }
    }

    /**
     * Manually validate status_id
     * because only first 5 status stages are available for analysts on update
     */
    public function updateFromRequest($request)
    {
        $this->fill($request->except('status_id'));
        $this->validateStatusID();
        $this->save();

        // BelongsToMany relations
        $this->owners()->sync($request->input('owners'));
        $this->crbeCountries()->sync($request->input('crbeCountries'));

        // HasMany relations
        $this->storeComment($request->comment);
    }

    /**
     * Manually validate status_id on updateFromRequest method
     * because only first 5 status stages are available for analysts on update
     */
    public function validateStatusID()
    {
        $newStatusID = request()->input('status_id');

        if ($this->status->id != $newStatusID) {
            // Admin
            if (request()->user()->isAdmin()) {
                $this->status_id = $newStatusID;
                // Analyst. Update status_id only if newStatusStage >= 5
            } else {
                // Avoid updating status_id if
                // old status stage > 5 and new status stage == ProcessStatus::STAGE_FIVE_RESPONSIBLE_CHILD_ID
                $oldStatusStage = $this->status->parent->stage;

                if (!($oldStatusStage >= 6 && $newStatusID == ProcessStatus::STAGE_FIVE_RESPONSIBLE_CHILD_ID)) {
                    $this->status_id = $newStatusID;
                }
            }
        }
    }

    /**
     * Validate days_past field relative to date field
     *
     * Default $now variable is used, because thousand of items
     * can be upated through loop
     *
     * Timestamps disabled because days past updated via Chron everyday

     * Used on models created & updated events
     */
    public function validateDaysPast($now = null)
    {
        $item = $this->fresh();
        if (!$now) $now = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $date = Carbon::createFromFormat('Y-m-d', $item->date);
        $item->days_past = $date->diffInDays($now, false);
        $item->timestamps = false;
        $item->saveQuietly();
        $item->timestamps = true;
    }

    /**
     * Update status_update_date field on status update
     *
     * Used on models updating event
     */
    public function validateStatusUpdateDate()
    {
        if ($this->isDirty('status_id')) {
            $this->status_update_date = date('Y-m-d');
        }
    }

    /**
     * Synchronize Generic Expiration date & Minimum volume columns
     *
     * Used on models creating & updating events
     */
    public function synchronizeGenericColumnsUpdate()
    {
        if (request('expiration_date_id')) {
            $generic = Generic::find($this->generic_id);
            $generic->expiration_date_id = request('expiration_date_id');
            $generic->minimum_volume = request('minimum_volume');

            if ($generic->isDirty('expiration_date_id') || $generic->isDirty('minimum_volume')) {
                $generic->save();
            }
        }
    }

    /**
     * Set stage_2_start_date field as now on stage >= 2 select
     *
     * Used on models created & updated events
     */
    public function validateStageTwoStartDate()
    {
        $item = $this->fresh();

        // Remove start date on status backward
        if ($item->status->parent->stage == 1) {
            $item->stage_2_start_date = null;
            $item->saveQuietly();
        }
        // Else Update date if already not set
        else if (!$item->stage_2_start_date) {
            $item->stage_2_start_date = date('Y-m-d');
            $item->saveQuietly();
        }
    }

    /**
     * Validate manufacturer_followed_offered_price_in_usd field
     * Timestamps disabled because days price updated via Chron everyday
     *
     * Used on models created & updated events
     */
    public function validatePriceInUSD()
    {
        $item = $this->fresh();

        $price = $item->manufacturer_followed_offered_price;
        $currencyName = $item->currency?->name;

        // $price & $currency can be null on early stages
        if ($price & $currencyName) {
            $converted = Currency::convertToUSD($price, $currencyName);
            $item->manufacturer_followed_offered_price_in_usd = $converted;
            $item->timestamps = false;
            $item->saveQuietly();
            $item->timestamps = true;
        }
    }

    /**
     * Update increased_price_percentage and increased_price_date fields,
     * due to agreed price, If increased_price field is filled
     *
     * Used on models created event
     */
    public function validateIncreasedPriceAfterCreate()
    {
        if ($this->increased_price) {
            $this->increased_price_percentage = round(($this->increased_price * 100) / $this->agreed_price, 2);
            $this->increased_price_date = date('Y-m-d');
            $this->saveQuietly();
        }
    }

    /**
     * Keep status change history
     *
     * Used on models created event
     */
    public function addStatusUpdateHistoryAfterCreate()
    {
        $this->statusUpdates()->save(
            new ProcessHistory([
                'action' => ProcessHistory::STATUS_UPDATE_ACTION_NAME,
                'options' => [
                    'new_status_id' => intval($this->status_id),
                ],
            ])
        );
    }

    /**
     * Keep status change history
     *
     * Used on models updating event
     */
    public function addStatusUpdateHistoryonUpdating()
    {
        // first update latest history adding last status duration_days & end_date values
        $latestStatusUpdate = $this->latestStatusUpdate;
        $options = $latestStatusUpdate->options;

        // calculate days past
        $latestStatusUpdateDate = Carbon::parse($latestStatusUpdate->created_at);
        $options['new_status_duration_days'] = $latestStatusUpdateDate->diffInDays(now());

        // also add finished_at value
        $options['new_status_end_date'] = now()->format('Y-m-d H:i:s');
        $latestStatusUpdate->options = $options;
        $latestStatusUpdate->save();

        // then add new history
        $this->statusUpdates()->save(
            new ProcessHistory([
                'action' => ProcessHistory::STATUS_UPDATE_ACTION_NAME,
                'options' => [
                    'new_status_id' => intval($this->status_id),
                ],
            ])
        );
    }

    /**
     * Update increased_price_percentage and increased_price_date fields,
     * due to agreed price, If increased_price field updated after stage 5
     *
     * Used on models updating event
     */
    public function validateIncreasedPriceOnUpdating()
    {
        if ($this->isDirty('increased_price')) {
            $this->increased_price_percentage = round(($this->increased_price * 100) / $this->agreed_price, 2);
            $this->increased_price_date = date('Y-m-d');
        }
    }

    /**
     * Attach each stage periods to the process (only first 5 stages)
     */
    public function loadStatusStagePeriods()
    {
        // First calculate start_date, end_date and duration_days for each stage
        $stages = [
            ["number" => 1, "start_date" => null, "end_date" => null, "duration_days" => 0, "line_length" => 0],
            ["number" => 2, "start_date" => null, "end_date" => null, "duration_days" => 0, "line_length" => 0],
            ["number" => 3, "start_date" => null, "end_date" => null, "duration_days" => 0, "line_length" => 0],
            ["number" => 4, "start_date" => null, "end_date" => null, "duration_days" => 0, "line_length" => 0],
            ["number" => 5, "start_date" => null, "end_date" => null, "duration_days" => 0, "line_length" => 0],
        ];

        foreach ($stages as &$stage) {
            // Stages after stage 5 are also included in stage 5
            if ($stage['number'] == 5) {
                $stageUpdates = $this->statusUpdates->where('newStatus.parent.stage', '>=', $stage['number']);
            } else {
                $stageUpdates = $this->statusUpdates->where('newStatus.parent.stage', $stage['number']);
            }

            if ($stageUpdates->count()) {
                $stage["start_date"] = Carbon::parse($stageUpdates->sortBy('id')->first()->created_at)->format('d/m/Y');

                // Calculate prcocess current status duration_days & set current stage end_date as current date
                // because they are null for current process status stage
                $lastUpdate = $stageUpdates->sortByDesc('id')->first();
                $lastUpdateOptions = $lastUpdate->options;

                if (!key_exists('new_status_end_date', $lastUpdate->options)) {
                    $stage["end_date"] = now()->format('d/m/Y');

                    // add directly to collection, because sum aggregate function is used to calculate stage duration days
                    $lastUpdateOptions['new_status_duration_days'] = Carbon::parse($lastUpdate->created_at)->diffInDays(now(), false);
                    $lastUpdate->options = $lastUpdateOptions;
                    // For past stages duration_days & end_date are already calculated
                } else {
                    $stage["end_date"] = Carbon::parse($lastUpdate->options['new_status_end_date'])->format('d/m/Y');
                }

                $stage["duration_days"] = $stageUpdates->sum(function ($update) {
                    return $update->options['new_status_duration_days'];
                });
            }
        }

        // Then calculate length of line for each stages accordiing to the highest period
        $highestPeriod = collect($stages)->max('duration_days');

        foreach ($stages as &$stage) {
            // escape division by zero
            if (!$highestPeriod) $highestPeriod = 1;

            $stage["line_length"] = $stage["duration_days"] ? intval($stage["duration_days"] * 100 / $highestPeriod) : 0;
        }

        $this->status_stage_periods = $stages;
    }

    public static function exportItems($items)
    {
        $template = storage_path(self::STORAGE_EXCEL_TEMPLATE_PATH);
        $spreadsheet = IOFactory::load($template);
        $worksheet = $spreadsheet->getActiveSheet();
        $row = 2;

        // fill excel cells
        $items->chunk(800, function ($items) use (&$worksheet, &$row) {
            foreach ($items as $item) {
                $worksheet->setCellValue('A' . $row, $item->id);
                $worksheet->setCellValue('B' . $row, $item->status_update_date);
                $worksheet->setCellValue('C' . $row, $item->countryCode->name);
                $worksheet->setCellValue('D' . $row, $item->manufacturer->category->name);
                $worksheet->setCellValue('E' . $row, $item->manufacturer->name);
                $worksheet->setCellValue('F' . $row, $item->manufacturer->country->name);
                $worksheet->setCellValue('G' . $row, $item->manufacturer->bdm->name);
                $worksheet->setCellValue('H' . $row, $item->manufacturer->analyst->name);
                $worksheet->setCellValue('I' . $row, $item->generic->mnn->name);
                $worksheet->setCellValue('J' . $row, $item->generic->form->name);
                $worksheet->setCellValue('K' . $row, $item->generic->dose);
                $worksheet->setCellValue('L' . $row, $item->generic->pack);

                $worksheet->setCellValue('M' . $row, $item->promoCompany?->name);
                $worksheet->setCellValue('N' . $row, $item->status->name);
                $worksheet->setCellValue('O' . $row, $item->status->parent->name_for_analysts);
                $worksheet->setCellValue('P' . $row, $item->status->parent->name_for_admins);

                $comments = $item->comments->pluck('body')->implode(' / ');
                $worksheet->setCellValue('Q' . $row, $comments);
                $worksheet->setCellValue('R' . $row, $item->lastComment?->created_at);

                $worksheet->setCellValue('S' . $row, $item->manufacturer_first_offered_price);
                $worksheet->setCellValue('T' . $row, $item->manufacturer_followed_offered_price);
                $worksheet->setCellValue('U' . $row, $item->currency?->name);
                $worksheet->setCellValue('V' . $row, $item->agreed_price);
                $worksheet->setCellValue('W' . $row, $item->manufacturer_followed_offered_price_in_usd);
                $worksheet->setCellValue('X' . $row, $item->our_followed_offered_price);
                $worksheet->setCellValue('Y' . $row, $item->our_first_offered_price);
                $worksheet->setCellValue('Z' . $row, $item->increased_price);
                $worksheet->setCellValue('AA' . $row, $item->increased_price_percentage);
                $worksheet->setCellValue('AB' . $row, $item->increased_price_date);
                $worksheet->setCellValue('AC' . $row, $item->generic->expirationDate->name);
                $worksheet->setCellValue('AD' . $row, $item->generic->minimum_volume);

                $worksheet->setCellValue('AE' . $row, $item->dossier_status);
                $worksheet->setCellValue('AF' . $row, $item->clinical_trial_year);

                $countries = $item->crbeCountries->pluck('name')->implode(' ');
                $worksheet->setCellValue('AG' . $row, $countries);

                $worksheet->setCellValue('AH' . $row, $item->clinical_trial_ich_country);

                $zones = $item->generic->zones->pluck('name')->implode(' ');
                $worksheet->setCellValue('AI' . $row, $zones);

                $worksheet->setCellValue('AJ' . $row, $item->additional_1);
                $worksheet->setCellValue('AK' . $row, $item->additional_2);
                $worksheet->setCellValue('AL' . $row, $item->stage_2_start_date);
                $worksheet->setCellValue('AM' . $row, $item->year_1);
                $worksheet->setCellValue('AN' . $row, $item->year_2);
                $worksheet->setCellValue('AO' . $row, $item->year_3);

                $owners = $item->owners->pluck('name')->implode(' ');
                $worksheet->setCellValue('AP' . $row, $owners);

                $worksheet->setCellValue('AQ' . $row, $item->date);
                $worksheet->setCellValue('AR' . $row, $item->days_past);
                $worksheet->setCellValue('AS' . $row, $item->trademark_en);
                $worksheet->setCellValue('AT' . $row, $item->trademark_ru);
                $worksheet->setCellValue('AU' . $row, $item->created_at);
                $worksheet->setCellValue('AV' . $row, $item->updated_at);
                $worksheet->setCellValue('AW' . $row, $item->generic->category->name);
                $row++;
            }
        });

        // save file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = date('Y-m-d H-i-s') . '.xlsx';
        $filename = Helper::escapeDuplicateFilename($filename, storage_path(self::STORAGE_EXCEL_EXPORT_PATH));
        $filePath = storage_path(self::STORAGE_EXCEL_EXPORT_PATH  . '/' . $filename);
        $writer->save($filePath);

        return response()->download($filePath);
    }
}
