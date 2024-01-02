<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KvppStatus extends Model
{
    use HasFactory;

    const ACTIVE_ITEM_NAME = 'Active';

    public $timestamps = false;

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
