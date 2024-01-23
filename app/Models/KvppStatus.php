<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KvppStatus extends Model
{
    use HasFactory;

    const ACTIVE_ITEM_NAME = 'Active';

    public $timestamps = false;

    public function kvpps()
    {
        return $this->hasMany(Kvpp::class, 'status_id');
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        return $this->kvpps()->count();
    }

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }

    /**
     * Used while highlighting KVPP inactive table items <tr> background
     */
    public static function getActiveItemID()
    {
        return self::where('name', self::ACTIVE_ITEM_NAME)->first()->id;
    }
}
