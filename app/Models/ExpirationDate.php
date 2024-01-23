<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationDate extends Model
{
    use HasFactory;

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

    public static function getOnGoingID()
    {
        return self::where('name', 'onGoing')->first()->id;
    }
}
