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
    const DEFAULT_PAGINATION_LIMIT = 20;

    public $timestamps = false;
    protected $guarded = ['id'];

    protected $with = [
        'countryCode',
        'status',
        'owners',
    ];

    // ********** Events **********
    protected static function booted(): void
    {
        static::creating(function ($item) {
            $item->status_update_date = now();
        });

        static::created(function ($item) {
            $item->validateDaysPast(now());
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

    // ********** Querying **********
    public function scopeWithRelations($query)
    {
        return $query->with([
            'generic' => function ($query) {
                $query->select('id', 'manufacturer_id', 'mnn_id', 'category_id', 'form_id', 'dose', 'pack')
                    ->withOnly(['mnn', 'category', 'form']);
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
        $countryCodes = $request->input('country_code_ids');

        foreach ($countryCodes as $countryCode) {
            $item = new self($request->all());
            $item->country_code_id = $countryCode;
            $item->save();

            // BelongsToMany relations
            $item->owners()->attach($request->input('owners'));
        }
    }

    public function validateDaysPast($now)
    {
        $date = Carbon::createFromFormat('Y-m-d', $this->date);
        $this->days_past = $now->diffInDays($date);
        $this->save();
    }
}
