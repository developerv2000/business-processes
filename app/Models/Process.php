<?php

namespace App\Models;

use App\Support\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'id';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 40;

    public $timestamps = false;
    protected $guarded = ['id'];

    protected $with = [
        'countryCode',
        'status',
        'owners',
        'currency',
    ];

    // ********** Events **********
    protected static function booted(): void
    {
        static::creating(function ($item) {
            $item->status_update_date = now();
            $item->synchronizeGenericColumnsUpdate();
        });

        static::created(function ($item) {
            $item->validateDaysPast();
            $item->validateStageTwoStartDate();
            $item->validatePriceInUSD();
            $item->validateIncreasedPriceAfterCreate();
        });

        static::updating(function ($item) {
            $item->validateStatusUpdateDate();
            $item->synchronizeGenericColumnsUpdate();
            $item->validateIncreasedPriceOnUpdating();
        });

        static::updated(function ($item) {
            $item->validateDaysPast();
            $item->validateStageTwoStartDate();
            $item->validatePriceInUSD();
        });
    }

    // ********** Relations **********
    public function generic()
    {
        return $this->belongsTo(Generic::class);
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
        );
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

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
        $items = self::finalize($params, $items, $finaly);

        return $items;
    }

    private static function filter($items)
    {
        $whereColumns = [
            'country_code_id',
            'status_id',
        ];

        $whereDateColumns = [
            'date',
        ];

        $whereRelationColumns = [
            [
                'relationName' => 'manufacturer',
                'name' => 'analyst_user_id',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'bdm_user_id',
            ],

            [
                'relationName' => 'generic',
                'name' => 'mnn_id',
            ],

            [
                'relationName' => 'generic',
                'name' => 'category_id',
            ],

            [
                'relationName' => 'generic',
                'name' => 'form_id',
            ],
        ];

        $whereRelationAmbigiousColumns = [
            [
                'relationName' => 'manufacturer',
                'name' => 'manufacturer_id',
                'ambigiousNme' => 'manufacturers.id',
            ],
        ];

        $whereRelationLikeColumns = [
            [
                'relationName' => 'generic',
                'name' => 'dose',
            ],

            [
                'relationName' => 'generic',
                'name' => 'pack',
            ],
        ];

        $belongsToManyRelations = [
            'owners',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereDateColumns($items, $whereDateColumns);
        $items = Helper::filterWhereRelationColumns($items, $whereRelationColumns);
        $items = Helper::filterWhereRelationAmbigiousColumns($items, $whereRelationAmbigiousColumns);
        $items = Helper::filterWhereRelationLikeColumns($items, $whereRelationLikeColumns);
        $items = Helper::filterBelongsToManyRelations($items, $belongsToManyRelations);

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

            // increment country code usage count for prioritizing
            $countryCode->usage_count = $countryCode->usage_count + 1;
            $countryCode->save();
        }
    }

    /**
     * Validate days_past field relative to date field
     *
     * Default $now variable is used, because thousand of items
     * can be upated through loop

     * Used on models created & updated events
     */
    public function validateDaysPast($now = null)
    {
        if (!$now) $now = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $date = Carbon::createFromFormat('Y-m-d', $this->date);
        $this->days_past = $date->diffInDays($now, false);
        $this->saveQuietly();
    }

    /**
     * Update status_update_date field on status update
     *
     * Used on models updating event
     */
    public function validateStatusUpdateDate()
    {
        if ($this->isDirty('status_id')) {
            $this->status_update_date = now();
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
            $generic->save();
        }
    }

    /**
     * Set stage_2_start_date field as now on stage >= 2 select
     *
     * Used on models created & updated events
     */
    public function validateStageTwoStartDate()
    {
        // Remove start date on status backward
        if ($this->status->parent->stage == 1) {
            $this->stage_2_start_date = null;
            $this->saveQuietly();
        }
        // Else update date if already not set
        else if (!$this->stage_2_start_date) {
            $this->stage_2_start_date = now();
            $this->saveQuietly();
        }
    }

    /**
     * Validate manufacturer_followed_offered_price_in_usd field
     *
     * Used on models created & updated events
     */
    public function validatePriceInUSD()
    {
        $price = $this->manufacturer_followed_offered_price;
        $currencyName = $this->currency?->name;

        // $price & $currency can be null on early stages
        if ($price & $currencyName) {
            $converted = Currency::convertToUSD($price, $currencyName);
            $this->manufacturer_followed_offered_price_in_usd = $converted;
            $this->saveQuietly();
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
            $this->increased_price_date = now();
            $this->saveQuietly();
        }
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
            $this->increased_price_date = now();
        }
    }
}
