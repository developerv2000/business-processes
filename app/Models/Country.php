<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function manufacturers()
    {
        return $this->hasMany(Manufacturer::class);
    }

    public function crbeProcesses()
    {
        return $this->belongsToMany(Process::class, 'process_crbecountry', 'country_id', 'process_id');
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        $manufacturers = $this->manufacturers()->count();
        $crbeProcesses = $this->crbeProcesses()->count();
        $totalCount = $manufacturers + $crbeProcesses;

        return $totalCount;
    }

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }
}
