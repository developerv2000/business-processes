<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Info extends Model
{
    use HasFactory;
    use NodeTrait;

    public $timestamps = false;
}
