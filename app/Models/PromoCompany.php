<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCompany extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function processes()
    {
        return $this->hasMany(Process::class);
    }

    public function kvpps()
    {
        return $this->belongsToMany(Kvpp::class, 'kvpp_promocompany');
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
        return self::orderBy('id')->get();
    }
}
