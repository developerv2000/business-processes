<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Generic extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'created_at';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 50;

    const STORAGE_EXCEL_TEMPLATE_PATH = 'app/excel/templates/ivp.xlsx';
    const STORAGE_EXCEL_EXPORT_PATH = 'app/excel/exports/ivp';
    const STORAGE_VP_EXCEL_TEMPLATE_PATH = 'app/excel/templates/ivp-vp.xlsx';
    const STORAGE_VP_EXCEL_EXPORT_PATH = 'app/excel/exports/ivp-vp';

    const VP_DEFAULT_COUNTRIES = [
        'KZ',
        'TM',
        'KG',
        'AM',
        'TJ',
        'UZ',
        'GE',
        'MN',
        'RU',
        'AZ',
        'AL',
        'KE',
        'DO',
        'KH',
        'MM',
    ];

    const VP_FIRST_DEFAULT_COUNTRY_COLUMN_INDEX = 'J';
    const VP_LAST_DEFAULT_COUNTRY_COLUMN_INDEX = 'X';
    const VP_TITLES_ROW_INDEX = 2;
    const VP_PRODUCTS_START_ROW_INDEX = 4;

    protected $guarded = ['id'];

    protected $with = [
        'mnn',
        'form',
        'expirationDate',
        'category',
        'zones',
        'lastComment',
    ];

    // ********** Events **********
    protected static function booted(): void
    {
        static::deleting(function ($item) {
            foreach ($item->untrashedProcesses as $process) {
                $process->delete();
            }
        });

        static::restoring(function ($item) {
            if ($item->manufacturer->trashed()) {
                $item->manufacturer->restoreQuietly();
            }

            foreach ($item->processes as $process) {
                if ($process->trashed()) {
                    $process->restoreQuietly();
                }
            }
        });

        static::forceDeleting(function ($item) {
            $item->zones()->detach();

            foreach ($item->comments as $comment) {
                $comment->delete();
            }

            foreach ($item->processes as $process) {
                $process->forceDelete();
            }
        });
    }

    // ********** Relations **********
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class)->withTrashed();
    }

    public function untrashedProcesses()
    {
        return $this->hasMany(Process::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class)->withTrashed();
    }

    public function mnn()
    {
        return $this->belongsTo(Mnn::class);
    }

    public function form()
    {
        return $this->belongsTo(ProductForm::class, 'form_id');
    }

    public function expirationDate()
    {
        return $this->belongsTo(ExpirationDate::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function lastComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }

    public function getProcessesLinkAttribute()
    {
        return route('processes.index')
            . '?manufacturer_id=' . $this->manufacturer_id
            . '&mnn_id=' . $this->mnn_id
            . '&form_id=' . $this->form_id
            . '&dose=' . urlencode($this->dose)
            . '&pack=' . urlencode($this->pack);
    }

    public function getCoincidentKvppsAttribute()
    {
        return Kvpp::where('mnn_id', $this->mnn_id)
            ->where('form_id', $this->form_id)
            ->where('dose', $this->dose)
            ->where('pack', $this->pack)
            ->select('id', 'country_code_id')
            ->withOnly('countryCode')
            ->get();
    }

    // ********** Querying **********
    public function scopeWithRelations($query)
    {
        return $query->with([
            'manufacturer' => function ($query) {
                $query->select('id', 'name', 'country_id', 'bdm_user_id', 'analyst_user_id', 'category_id')
                    ->withOnly(['country', 'bdm:id,name,photo', 'analyst:id,name,photo', 'category']);
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
            'manufacturer_id',
            'mnn_id',
            'form_id',
            'category_id',
            'expiration_date_id',
            'registered_in_eu',
            'marketed_in_eu',
        ];

        $whereLikeColumns = [
            'dose',
            'pack',
            'brand',
        ];

        $whereDateRangeColumns = [
            'created_at',
            'updated_at',
        ];

        $whereRelationColumns = [
            [
                'relationName' => 'manufacturer',
                'name' => 'country_id',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'analyst_user_id',
            ],

            [
                'relationName' => 'manufacturer',
                'name' => 'bdm_user_id',
            ],
        ];

        $whereRelationAmbigiousColumns = [
            [
                'relationName' => 'manufacturer',
                'name' => 'manufacturer_category_id',
                'ambigiousNme' => 'manufacturers.category_id',
            ],
        ];

        $belongsToManyRelations = [
            'zones',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereLikeColumns($items, $whereLikeColumns);
        $items = Helper::filterWhereDateRangeColumns($items, $whereDateRangeColumns);
        $items = Helper::filterWhereRelationColumns($items, $whereRelationColumns);
        $items = Helper::filterWhereRelationAmbigiousColumns($items, $whereRelationAmbigiousColumns);
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
                    ->withCount('untrashedProcesses')
                    ->paginate($params['paginationLimit'], ['*'], 'page', $params['currentPage'])
                    ->appends(request()->except('page'));
                break;

            case 'get':
                $items = $items->get();
                break;

            case 'query':
                break;
        }

        return $items;
    }

    public static function getSimilarProducts($request)
    {
        // combine all available forms (parent and childs) in array
        $formFamilyIDs = ProductForm::find($request->form_id)->getFamilyIDs();

        return Generic::where('manufacturer_id', $request->manufacturer_id)
            ->where('mnn_id', $request->mnn_id)
            ->whereIn('form_id', $formFamilyIDs)
            ->get();
    }

    // ********** Miscellaneous **********
    public function getAllComments()
    {
        return $this->comments()->latest()->get();
    }

    public static function createFromRequest($request)
    {
        $item = self::create($request->all());

        // BelongsToMany relations
        $item->zones()->attach($request->input('zones'));

        // HasMany relations
        $item->storeComment($request->comment);
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());
        $this->validateCheckboxAttributes($request);

        // BelongsToMany relations
        $this->zones()->sync($request->input('zones'));

        // HasMany relations
        $this->storeComment($request->comment);
    }

    /**
     * Used on Process create
     * Only first 3 stages are used
     */
    public function getProposedProcessStatus()
    {
        // First stage (Вб)
        if ($this->expiration_date_id == ExpirationDate::getTbcID()) {
            $stage = 1;
            // Second stage (ПО)
        } else if (!$this->minimum_volume) {
            $stage = 2;
            // Third stage (АЦ)
        } else {
            $stage = 3;
        }

        $rootStatus = ProcessStatus::where('stage', $stage)->first();

        return $rootStatus->responsibleChild;
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
                $worksheet->setCellValue('A' . $row, $item->manufacturer->category->name);
                $worksheet->setCellValue('B' . $row, $item->manufacturer->country->name);
                $worksheet->setCellValue('C' . $row, $item->manufacturer->name);
                $worksheet->setCellValue('D' . $row, $item->brand);
                $worksheet->setCellValue('E' . $row, $item->mnn->name);
                $worksheet->setCellValue('F' . $row, $item->form->name);
                $worksheet->setCellValue('G' . $row, $item->form->parent ? $item->form->parent->name : $item->form->name);
                $worksheet->setCellValue('H' . $row, $item->dose);
                $worksheet->setCellValue('I' . $row, $item->pack);
                $worksheet->setCellValue('J' . $row, $item->minimum_volume);
                $worksheet->setCellValue('K' . $row, $item->expirationDate->name);
                $worksheet->setCellValue('L' . $row, $item->category->name);
                $worksheet->setCellValue('M' . $row, $item->dossier);

                $zones = $item->zones->pluck('name')->implode(' ');
                $worksheet->setCellValue('N' . $row, $zones);

                $worksheet->setCellValue('O' . $row, $item->bioequivalence);
                $worksheet->setCellValue('P' . $row, $item->patent_expiry);
                $worksheet->setCellValue('Q' . $row, $item->registered_in_eu ? __('Registered') : '');
                $worksheet->setCellValue('R' . $row, $item->marketed_in_eu ? __('Sold') : '');
                $worksheet->setCellValue('S' . $row, $item->additional_payment);

                $comments = $item->comments->pluck('body')->implode(' / ');
                $worksheet->setCellValue('T' . $row, $comments);

                $worksheet->setCellValue('U' . $row, $item->lastComment?->created_at);
                $worksheet->setCellValue('V' . $row, $item->manufacturer->bdm->name);
                $worksheet->setCellValue('W' . $row, $item->manufacturer->analyst->name);
                $worksheet->setCellValue('X' . $row, $item->created_at);
                $worksheet->setCellValue('Y' . $row, $item->updated_at);
                $worksheet->setCellValue('Z' . $row, $item->id);

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

    public static function exportVpItems($query, $manufacturerName)
    {
        // create new excel file from template
        $template = storage_path(self::STORAGE_VP_EXCEL_TEMPLATE_PATH);
        $spreadsheet = IOFactory::load($template);
        $worksheet = $spreadsheet->getActiveSheet();

        // collect all items chunked
        $allItems = collect();
        $query->chunk(400, function ($chunked) use (&$allItems) {
            $allItems = $allItems->merge($chunked);
        });

        // append coincident_kvpps manually, so it won`t load many times
        $allItems->each(function ($item) {
            $item->coincident_kvpps = $item->coincident_kvpps;
        });

        // collect unique additional countries
        $additionalCountries = collect();
        foreach ($allItems as $item) {
            $additionalCountries = $additionalCountries->merge($item->coincident_kvpps->pluck('countryCode.name'));
        }
        $additionalCountries = $additionalCountries->unique();

        // remove countries that already exist in default countries from additional countries
        $defaultCountries = collect(self::VP_DEFAULT_COUNTRIES);
        $additionalCountries = $additionalCountries->diff($defaultCountries);

        // insert additional country titles between last default country and ZONE 4B columns
        $lastDefaultCountryColumnIndex = self::VP_LAST_DEFAULT_COUNTRY_COLUMN_INDEX;
        $lastCountryColumnIndex = $lastDefaultCountryColumnIndex; // used in loop for storing previous inserted country index

        foreach ($additionalCountries as $country) {
            // insert country title
            $nextCountryColumnIndex = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($lastCountryColumnIndex) + 1);
            $worksheet->insertNewColumnBefore($nextCountryColumnIndex, 1);
            $insertedCellCoordinates = $nextCountryColumnIndex . self::VP_TITLES_ROW_INDEX;
            $worksheet->setCellValue($insertedCellCoordinates, $country);

            // update cell styles
            $worksheet->getColumnDimension($nextCountryColumnIndex)->setWidth(5);
            $cellStyle = $worksheet->getCell($insertedCellCoordinates)->getStyle();
            $cellStyle->getFill()->getStartColor()->setARGB('00FFFF');
            $cellStyle->getFont()->setColor(new Color(Color::COLOR_BLACK));
        }

        // join default and additional countries
        $allCountries = $defaultCountries->merge($additionalCountries);

        // insert product rows
        $rowIndex = self::VP_PRODUCTS_START_ROW_INDEX;
        $productsCounter = 1;

        foreach ($allItems as $item) {
            $worksheet->setCellValue('A' . $rowIndex, $productsCounter);
            $worksheet->setCellValue('B' . $rowIndex, $item->mnn->name);
            $worksheet->setCellValue('C' . $rowIndex, $item->form->name);
            $worksheet->setCellValue('D' . $rowIndex, $item->dose);
            $worksheet->setCellValue('E' . $rowIndex, $item->pack);
            $worksheet->setCellValue('F' . $rowIndex, $item->minimum_volume);
            $worksheet->setCellValue('G' . $rowIndex, $item->expirationDate->name);

            $countryColumnIndex = self::VP_FIRST_DEFAULT_COUNTRY_COLUMN_INDEX; // reset value for each row

            foreach ($allCountries as $country) {
                $cellIndex = $countryColumnIndex . $rowIndex;
                $cellStyle = $worksheet->getCell($cellIndex)->getStyle();

                if ($item->coincident_kvpps->contains('countryCode.name', $country)) {
                    $worksheet->setCellValue($cellIndex, '1');
                    $cellStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $cellStyle->getFill()->getStartColor()->setARGB('92D050');
                } else {
                    // reset background color because new inserted rows copy previous row styles
                    $cellStyle->getFill()->getStartColor()->setARGB('FFFFFF');
                }

                $countryColumnIndex = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($countryColumnIndex) + 1);
            }

            $rowIndex++;
            $productsCounter++;
            $worksheet->insertNewRowBefore($rowIndex, 1); // insert new rows to escape rewriting default countries list
        }

        // remove last excess inserted row
        if ($allItems->count()) {
            $worksheet->removeRow($rowIndex);
        }

        // save file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = $manufacturerName . date(' Y-m-d') . '.xlsx';
        $filename = Helper::escapeDuplicateFilename($filename, storage_path(self::STORAGE_VP_EXCEL_EXPORT_PATH));
        $filePath = storage_path(self::STORAGE_VP_EXCEL_EXPORT_PATH  . '/' . $filename);
        $writer->save($filePath);

        return response()->download($filePath);
    }

    public function loadComments()
    {
        return $this->load(['comments' => function ($query) {
            $query->orderBy('id', 'desc');
        }]);
    }

    /**
     * Unchecked attributes won`t come with request
     * Thats why manual validation added
     */
    private function validateCheckboxAttributes($request)
    {
        $this->registered_in_eu = $request->registered_in_eu ?? 0;
        $this->marketed_in_eu = $request->marketed_in_eu ?? 0;
        $this->save();
    }

    private function storeComment($comment)
    {
        if (!$comment) return;

        $this->comments()->save(
            new Comment(['body' => $comment, 'user_id' => request()->user()->id, 'created_at' => now()]),
        );
    }
}
