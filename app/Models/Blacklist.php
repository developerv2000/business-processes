<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory;

    const NO_CONTACT_INFO = 'No contact info';
    const NO_INTERESTING_PD = 'No interesting Pd';
    const MARKETS = 'Markets';
    const PRICES = 'Prices';
    const LICENSE_FEE = 'License Fee';
    const BUSINESS_MODEL = 'Business Model';
    const DOSSIER_AND_OTHER_DOCS = 'Dossier and other docs';
    const CDMO = 'CDMO';
    const API_MFG = 'API MFG';

    public $timestamps = false;

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
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
