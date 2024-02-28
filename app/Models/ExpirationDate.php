<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationDate extends Model
{
    use HasFactory;

    const TBC_NAME = 'TBC';

    public $timestamps = false;

    public function generics()
    {
        return $this->hasMany(Generic::class);
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        return $this->generics()->count();
    }

    public static function getAll()
    {
        return self::orderBy('id')->get();
    }

    public static function getTbcID()
    {
        return self::where('name', self::TBC_NAME)->first()->id;
    }
}
