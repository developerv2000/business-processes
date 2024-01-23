<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessOwner extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'process_processowners', 'owner_id', 'process_id');
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        return $this->processes()->count();
    }

    public static function getAll()
    {
        return self::orderBy('id')->get();
    }
}
