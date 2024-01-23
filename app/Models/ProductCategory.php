<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }

    public function generics()
    {
        return $this->hasMany(Generic::class, 'category_id');
    }

    /**
     * Used in dashboard of Identical Models
     */
    public function getUsageCountAttribute()
    {
        $manufacturers = $this->manufacturers()->count();
        $generics = $this->generics()->count();
        $totalCount = $generics + $manufacturers;

        return $totalCount;
    }

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }
}
