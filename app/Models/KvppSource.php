<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KvppSource extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getAll()
    {
        return self::orderBy('name')->get();
    }
}
