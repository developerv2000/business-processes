<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mnn extends Model
{
    use HasFactory;

    const DEFAULT_ORDER_BY = 'name';
    const DEFAULT_ORDER_TYPE = 'asc';
    const DEFAULT_PAGINATION_LIMIT = 100;

    public $timestamps = false;
    protected $guarded = ['id'];

    // ********** Events **********
    protected static function booted(): void
    {
        static::deleting(function ($item) {
            foreach ($item->generics as $generic) {
                $generic->forceDelete();
            }
        });
    }

    // ********** Relations **********
    public function generics()
    {
        return $this->hasMany(Generic::class);
    }

    public function kvpps()
    {
        return $this->hasMany(Kvpp::class);
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        $generics = $this->generics()->count();
        $kvpps = $this->kvpps()->count();
        $totalCount = $generics + $kvpps;

        return $totalCount;
    }

    // ********** Querying **********
    public static function getAll()
    {
        return self::orderBy('name')->get();
    }
}
