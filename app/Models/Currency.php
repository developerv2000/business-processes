<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    use HasFactory;

    public $timestamps = false;

    const EXCHANGE_RATE_URL = 'https://v6.exchangerate-api.com/v6/2b3965359716e1bb35e7a237/latest/';

    public static function updateAll()
    {
        self::where('name', '!=', 'USD')->each(function ($item) {
            $response = Http::get(self::EXCHANGE_RATE_URL . $item->name);
            $item->usd_ratio = ($response->json())['conversion_rates']['USD'];
            $item->save();
        });
    }

    public static function getAll()
    {
        return self::orderBy('id')->get();
    }
}
