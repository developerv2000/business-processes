<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductForm extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $with = [
        'parent'
    ];

    public function generics()
    {
        return $this->hasMany(Generic::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }

    public function getFamilyIDs()
    {
        $parent = $this->parent ?: $this;

        // Pluck child IDs and push parent id
        $IDs = $parent->childs->pluck('id');
        $IDs[] = $parent->id;

        return $IDs;
    }
}
