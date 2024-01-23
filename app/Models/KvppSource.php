<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KvppSource extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function kvpps()
    {
        return $this->hasMany(Kvpp::class, 'source_id');
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
}
