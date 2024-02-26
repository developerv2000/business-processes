<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Info extends Model
{
    use HasFactory;
    use NodeTrait;

    const DEFAULT_ORDER_BY = 'name';
    const DEFAULT_ORDER_TYPE = 'asc';
    const DEFAULT_PAGINATION_LIMIT = 50;

    public $timestamps = false;
    protected $guarded = ['id'];

    // ********** Events **********
    protected static function booted(): void
    {
        static::deleting(function ($item) {
            foreach ($item->children as $child) {
                $child->delete();
            }
        });
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
            'id',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);

        return $items;
    }

    private static function finalize($params, $items, $finaly)
    {
        $items = $items
            ->orderBy($params['orderBy'], $params['orderType'])
            ->orderBy('id', $params['orderType']);

        switch ($finaly) {
            case 'paginate':
                return $items->paginate($params['paginationLimit'], ['*'], 'page', $params['currentPage'])
                    ->appends(request()->except('page'));

            case 'get':
                return $items->get();

            case 'query':
                break;
        }

        return $items;
    }

    public static function getAllMinified()
    {
        return self::select('id', 'name')->get();
    }

    // ********** Miscellaneous **********
    public static function createFromRequest($request)
    {
        self::create($request->all());
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());
        $this->validateCheckboxAttributes($request);
    }

    /**
     * Unchecked attributes won`t come with request
     * Thats why manual validation added
     */
    private function validateCheckboxAttributes($request)
    {
        $this->is_collapse = $request->is_collapse ?? 0;
        $this->save();
    }
}
