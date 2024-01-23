<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function manufacturers()
    {
        return $this->hasMany(Manufacturer::class, 'category_id');
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        return $this->manufacturers()->count();
    }

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }
}
