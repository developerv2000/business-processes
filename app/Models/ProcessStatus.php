<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $with = [
        'parent'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function scopeOnlyChilds($query)
    {
        $query->whereNotNull('parent_id');
    }

    public static function getAll()
    {
        return self::orderBy('id')->get();
    }

    public static function getAllChilds()
    {
        return self::onlyChilds()->orderBy('id')->get();
    }
}
