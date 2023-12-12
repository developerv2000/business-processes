<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'id';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 40;
    const START_FROM_YEAR = 2016;

    public $timestamps = false;
    protected $guarded = ['id'];

    // ********** Events **********
    protected static function booted(): void
    {
        static::restoring(function ($item) {
            if ($item->manufacturer->trashed()) {
                $item->manufacturer->restoreQuietly();
            }
        });
    }

    // ********** Relations **********
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class)->withTrashed();
    }

    // ********** Querying **********
    public function scopeWithRelations($query)
    {
        return $query->with([
            'manufacturer' => function ($query) {
                $query->select('id', 'name', 'country_id', 'bdm_user_id', 'analyst_user_id')
                    ->withOnly(['country', 'bdm:id,name,photo', 'analyst:id,name,photo']);
            },
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
            'year',
        ];

        $whereLikeColumns = [
            'who_met'
        ];

        $whereRelationColumns = [
            [
                'name' => 'country_id',
                'relationName' => 'manufacturer',
            ],

            [
                'name' => 'analyst_user_id',
                'relationName' => 'manufacturer',
            ],

            [
                'name' => 'bdm_user_id',
                'relationName' => 'manufacturer',
            ],
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereLikeColumns($items, $whereLikeColumns);
        $items = Helper::filterWhereRelationColumns($items, $whereRelationColumns);

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
        self::create($request->all());
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());
    }

    public static function getAvailableYears()
    {
        $startYear = self::START_FROM_YEAR;
        $endYear = date('Y') + 1;
        $years = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = $year;
        }

        return $years;
    }
}
