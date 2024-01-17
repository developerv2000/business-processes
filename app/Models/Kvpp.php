<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kvpp extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'created_at';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 50;

    const STORAGE_EXCEL_TEMPLATE_PATH = 'app/excel/templates/kvpp.xlsx';
    const STORAGE_EXCEL_EXPORT_PATH = 'app/excel/exports/kvpp';

    protected $guarded = ['id'];

    protected $with = [
        'status',
        'countryCode',
        'priority',
        'source',
        'mnn',
        'form',
        'promoCompany',
        'portfolioManager',
        'lastComment',
    ];

    // ********** Events **********
    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            foreach ($item->comments as $comment) {
                $comment->delete();
            }
        });
    }

    // ********** Relations **********
    public function status()
    {
        return $this->belongsTo(KvppStatus::class, 'status_id');
    }

    public function countryCode()
    {
        return $this->belongsTo(CountryCode::class);
    }

    public function priority()
    {
        return $this->belongsTo(KvppPriority::class, 'priority_id');
    }

    public function source()
    {
        return $this->belongsTo(KvppSource::class, 'source_id');
    }

    public function mnn()
    {
        return $this->belongsTo(Mnn::class);
    }

    public function form()
    {
        return $this->belongsTo(ProductForm::class, 'form_id');
    }

    public function promoCompany()
    {
        return $this->belongsTo(PromoCompany::class);
    }

    public function portfolioManager()
    {
        return $this->belongsTo(PortfolioManager::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function lastComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
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

    public static function createFromRequest($request)
    {
        $item = self::create($request->all());

        // HasMany relations
        $item->storeComment($request->comment);
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());

        // HasMany relations
        $this->storeComment($request->comment);
    }

    private function storeComment($comment)
    {
        if (!$comment) return;

        $this->comments()->save(
            new Comment(['body' => $comment, 'user_id' => request()->user()->id, 'created_at' => now()]),
        );
    }

    /**
     * Used to highlight inactive table items <tr> background
     */
    public function notActive()
    {
        return $this->status->id != KvppStatus::getActiveItemID();
    }

    public function getCoincidentProcesses()
    {
        return Process::whereHas('generic', function ($query) {
            $query->where([
                'mnn_id' => $this->mnn_id,
                'form_id' => $this->form_id,
                'dose' => $this->dose,
                'pack' => $this->pack,
            ]);
        })
            ->where('country_code_id', $this->country_code_id)
            ->select('id', 'status_id')
            ->withOnly('status')
            ->get();
    }

    public function getCoincidentGenericsCount()
    {
        return Generic::where([
            'mnn_id' => $this->mnn_id,
            'form_id' => $this->form_id,
        ])->count();
    }
}
