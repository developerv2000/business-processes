<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Manufacturer extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'created_at';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 20;

    const STORAGE_EXCEL_TEMPLATE_PATH = 'app/excel/templates/epp.xlsx';
    const STORAGE_EXCEL_EXPORT_PATH = 'app/excel/exports/epp';

    protected $guarded = ['id'];

    protected $with = [
        'bdm:id,name,photo',
        'analyst:id,name,photo',
        'country',
        'category',
        'zones',
        'productCategories',
        'blacklists',
        'lastComment',
        'presences',
    ];

    // ********** Mutators **********
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

    // ********** Events **********
    protected static function booted(): void
    {
        static::deleting(function ($item) {
            foreach ($item->meetings as $meeting) {
                $meeting->delete();
            }

            foreach ($item->generics as $generic) {
                $generic->delete();
            }
        });

        static::restored(function ($item) {
            foreach ($item->meetings()->onlyTrashed()->get() as $meeting) {
                $meeting->restore();
            }

            foreach ($item->generics()->onlyTrashed()->get() as $generic) {
                $generic->restore();
            }
        });

        static::forceDeleting(function ($item) {
            $item->zones()->detach();
            $item->productCategories()->detach();
            $item->blacklists()->detach();

            foreach ($item->comments as $comment) {
                $comment->delete();
            }

            foreach ($item->presences as $presence) {
                $presence->delete();
            }

            foreach ($item->meetings()->withTrashed()->get() as $meeting) {
                $meeting->forceDelete();
            }

            foreach ($item->generics()->withTrashed()->get() as $generic) {
                $generic->forceDelete();
            }
        });
    }

    // ********** Relations **********
    public function bdm()
    {
        return $this->belongsTo(User::class, 'bdm_user_id');
    }

    public function analyst()
    {
        return $this->belongsTo(User::class, 'analyst_user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function category()
    {
        return $this->belongsTo(ManufacturerCategory::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class);
    }

    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function blacklists()
    {
        return $this->belongsToMany(Blacklist::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function lastComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function generics()
    {
        return $this->hasMany(Generic::class);
    }

    // ********** Querying **********
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
            'category_id',
            'bdm_user_id',
            'analyst_user_id',
            'country_id',
            'cooperates',
            'active',
            'important',
        ];

        $whereDateColumns = [
            'created_at'
        ];

        $whereLikeColumns = [
            'name'
        ];

        $whereBetweenDateColumns = [
            [
                'name' => 'created_at',
                'from_date' => 'created_from_date',
                'to_date' => 'created_to_date',
            ]
        ];

        $belongsToManyRelations = [
            'zones',
            'productCategories',
            'blacklists',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereDateColumns($items, $whereDateColumns);
        $items = Helper::filterWhereLikeColumns($items, $whereLikeColumns);
        $items = Helper::filterWhereBetweenDateColumns($items, $whereBetweenDateColumns);
        $items = Helper::filterBelongsToManyRelations($items, $belongsToManyRelations);

        return $items;
    }

    private static function finalize($params, $items, $finaly)
    {
        $items = $items
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

    /**
     * Used in related model pages
     */
    public static function getAllUMinifed()
    {
        return self::select('id', 'name')->withOnly([])->get();
    }

    public function getAllComments()
    {
        return $this->comments()->latest()->get();
    }

    // ********** Miscellaneous **********
    public static function createFromRequest($request)
    {
        $item = self::create($request->all());

        // BelongsToMany relations
        $item->zones()->attach($request->input('zones'));
        $item->productCategories()->attach($request->input('productCategories'));
        $item->blacklists()->attach($request->input('blacklists'));

        // HasMany relations
        $item->storeComment($request->comment);
        $item->storePresences($request->presences);
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());
        $this->validateCheckboxAttributes($request);

        // BelongsToMany relations
        $this->zones()->sync($request->input('zones'));
        $this->productCategories()->sync($request->input('productCategories'));
        $this->blacklists()->sync($request->input('blacklists'));

        // HasMany relations
        $this->storeComment($request->comment);
        $this->syncPresences($request->presences);
    }

    public static function exportItems($items)
    {
        $template = storage_path(self::STORAGE_EXCEL_TEMPLATE_PATH);
        $spreadsheet = IOFactory::load($template);
        $worksheet = $spreadsheet->getActiveSheet();
        $row = 2;

        // fill excel cells
        foreach ($items as $item) {
            $worksheet->setCellValue('A' . $row, $item->id);
            $worksheet->setCellValue('B' . $row, $item->updated_at);
            $worksheet->setCellValue('C' . $row, $item->bdm->name);
            $worksheet->setCellValue('D' . $row, $item->analyst->name);
            $worksheet->setCellValue('E' . $row, $item->category->name);
            $worksheet->setCellValue('F' . $row, $item->country->name);
            $worksheet->setCellValue('G' . $row, $item->name);
            $worksheet->setCellValue('H' . $row, $item->cooperates ? __('Cooperates') : '');
            $worksheet->setCellValue('I' . $row, $item->active ? __('Active') : __('Stoped'));
            $worksheet->setCellValue('J' . $row, $item->important ? __('Important') : '');

            $prodCategories = $item->productCategories->pluck('name')->implode(' ');
            $worksheet->setCellValue('K' . $row, $prodCategories);

            $zones = $item->zones->pluck('name')->implode(' ');
            $worksheet->setCellValue('L' . $row, $zones);

            $blacklists = $item->blacklists->pluck('name')->implode(' ');
            $worksheet->setCellValue('M' . $row, $blacklists);

            $presences = $item->presences->pluck('name')->implode(' ');
            $worksheet->setCellValue('N' . $row, $presences);

            $worksheet->setCellValue('O' . $row, $item->website);
            $worksheet->setCellValue('P' . $row, $item->profile);
            $worksheet->setCellValue('Q' . $row, $item->relationships);

            $comments = $item->comments->pluck('body')->implode(' / ');
            $worksheet->setCellValue('R' . $row, $comments);

            $worksheet->setCellValue('S' . $row, $item->lastComment?->created_at);
            $worksheet->setCellValue('T' . $row, $item->created_at);

            $row++;
        }

        // save file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = date('Y-m-d H-i-s') . '.xlsx';
        $filename = Helper::escapeDuplicateFilename($filename, storage_path(self::STORAGE_EXCEL_EXPORT_PATH));
        $filePath = storage_path(self::STORAGE_EXCEL_EXPORT_PATH  . '/' . $filename);
        $writer->save($filePath);

        return response()->download($filePath);
    }

    public static function getStatusOptions()
    {
        return [
            ['label' => trans('Active'), 'value' => 1],
            ['label' => trans('Stop/pause'), 'value' => 0],
        ];
    }

    /**
     * Unchecked attributes won`t come with request
     * Thats why manual validation added
     */
    private function validateCheckboxAttributes($request)
    {
        $this->cooperates = $request->cooperates ?? 0;
        $this->important = $request->important ?? 0;
        $this->save();
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

    private function storePresences($presences)
    {
        if (!$presences) return;

        foreach ($presences as $presence) {
            $this->presences()->save(
                new Presence(['name' => $presence]),
            );
        }
    }

    private function syncPresences($presences)
    {
        // remove
        if (!$presences) {
            foreach ($this->presences as $presence) {
                $presence->delete();
            }

            return;
        }

        // add new items
        foreach ($presences as $presence) {
            if ($this->presences->doesntContain('name', $presence)) {
                $this->presences()->save(
                    new Presence(['name' => $presence]),
                );
            }
        }

        // delete removed items
        foreach ($this->presences as $presence) {
            if (!in_array($presence->name, $presences)) {
                $presence->delete();
            }
        }
    }
}
