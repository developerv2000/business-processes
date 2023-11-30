<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Generic extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'created_at';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 20;

    const STORAGE_EXCEL_TEMPLATE_PATH = 'app/excel/templates/ivp.xlsx';
    const STORAGE_EXCEL_EXPORT_PATH = 'app/excel/exports/ivp';

    public $timestamps = false;
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
        static::restoring(function ($item) {
            if ($item->manufacturer->trashed()) {
                $item->manufacturer->restoreQuietly();
            }
        });

        static::forceDeleting(function ($item) {
            $item->zones()->detach();

            foreach ($item->comments as $comment) {
                $comment->delete();
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
            . '&dose=' . $this->dose
            . '&pack=' . $this->pack;
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

        $whereDateColumns = [
            'created_at'
        ];

        $whereLikeColumns = [
            'dose',
            'pack',
            'brand',
        ];

        $whereBetweenDateColumns = [
            [
                'name' => 'created_at',
                'from_date' => 'created_from_date',
                'to_date' => 'created_to_date',
            ]
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
        ];

        $belongsToManyRelations = [
            'zones',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereDateColumns($items, $whereDateColumns);
        $items = Helper::filterWhereLikeColumns($items, $whereLikeColumns);
        $items = Helper::filterWhereBetweenDateColumns($items, $whereBetweenDateColumns);
        $items = Helper::filterWhereRelationColumns($items, $whereRelationColumns);
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
        $item = new Generic($request->all());
        $item->created_at = now();
        $item->save();

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

    public static function exportItems($items)
    {
        $template = storage_path(self::STORAGE_EXCEL_TEMPLATE_PATH);
        $spreadsheet = IOFactory::load($template);
        $worksheet = $spreadsheet->getActiveSheet();
        $row = 2;

        // fill excel cells
        $items->chunk(100, function ($items) use (&$worksheet, &$row) {
            foreach ($items as $item) {
                $worksheet->setCellValue('A' . $row, $item->id);
                $worksheet->setCellValue('B' . $row, $item->created_at);
                $worksheet->setCellValue('C' . $row, $item->manufacturer->category->name);
                $worksheet->setCellValue('D' . $row, $item->manufacturer->country->name);
                $worksheet->setCellValue('E' . $row, $item->manufacturer->name);
                $worksheet->setCellValue('F' . $row, $item->brand);
                $worksheet->setCellValue('G' . $row, $item->mnn->name);
                $worksheet->setCellValue('H' . $row, $item->form->name);
                $worksheet->setCellValue('I' . $row, $item->form->parent ? $item->form->parent->name : $item->form->name);
                $worksheet->setCellValue('J' . $row, $item->dose);
                $worksheet->setCellValue('K' . $row, $item->pack);
                $worksheet->setCellValue('L' . $row, $item->minimum_volume);
                $worksheet->setCellValue('M' . $row, $item->expirationDate->limit);
                $worksheet->setCellValue('N' . $row, $item->category->name);
                $worksheet->setCellValue('O' . $row, $item->dossier);

                $zones = $item->zones->pluck('name')->implode(' ');
                $worksheet->setCellValue('P' . $row, $zones);

                $worksheet->setCellValue('Q' . $row, $item->bioequivalence);
                $worksheet->setCellValue('R' . $row, $item->additional_payment);
                $worksheet->setCellValue('S' . $row, $item->relationships);
                $worksheet->setCellValue('T' . $row, $item->info);
                $worksheet->setCellValue('U' . $row, $item->patent_expiry);
                $worksheet->setCellValue('V' . $row, $item->registered_in_eu ? __('Registered') : '');
                $worksheet->setCellValue('W' . $row, $item->marketed_in_eu ? __('Marketed') : '');

                $comments = $item->comments->pluck('body')->implode(' / ');
                $worksheet->setCellValue('X' . $row, $comments);

                $worksheet->setCellValue('Y' . $row, $item->lastComment?->created_at);
                $worksheet->setCellValue('Z' . $row, $item->manufacturer->bdm->name);
                $worksheet->setCellValue('AA' . $row, $item->manufacturer->analyst->name);

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
