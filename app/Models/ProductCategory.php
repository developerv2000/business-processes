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
        return $this->belongsToMany(Generic::class);
    }

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }
}
