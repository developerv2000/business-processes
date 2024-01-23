<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function processes()
    {
        return $this->hasMany(Process::class);
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
        $processes = $this->processes()->count();
        $kvpps = $this->kvpps()->count();
        $totalCount = $processes + $kvpps;

        return $totalCount;
    }

    public static function getAll()
    {
        return self::orderBy('usage_count', 'desc')->get();
    }
}
