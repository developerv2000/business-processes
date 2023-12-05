<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationDate extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function generics()
    {
        return $this->hasMany(Generic::class);
    }

    public static function getAll()
    {
        return self::orderBy('id')->get();
    }

    public static function getOnGoingID()
    {
        return self::where('limit', 'onGoing')->first()->id;
    }
}
