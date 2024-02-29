<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStatus extends Model
{
    use HasFactory;

    const STAGE_FIVE_RESPONSIBLE_CHILD_ID = 20;

    public $timestamps = false;

    public $with = [
        'parent'
    ];

    public function getNameAttribute()
    {
        return request()->user()->isAdmin() ? $this->name_for_admins : $this->name_for_analysts;
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Exclude child statusses that came after stage 5 ('Кк') for analysts.
     * There are used only by admins
     */
    public static function filterChildsByRoles($items)
    {
        if (!request()->user()->isAdmin()) {
            $items = $items->whereHas('parent', function ($query) {
                $query->where('stage', '<=', '5');
            });
        }

        return $items;
    }

    /**
     * Each root processes got stage responsible child,
     * which are used as proposed status, while creating process
     *
     * At the current time only 3 first stages are used
     */
    public function responsibleChild()
    {
        return $this->hasOne(self::class, 'id', 'responsible_child_id');
    }

    public function scopeOnlyChilds($query)
    {
        $query->whereNotNull('parent_id');
    }

    public static function getAllChilds()
    {
        $query = self::onlyChilds();
        $query = self::filterChildsByRoles($query);

        return $query->get();
    }
}
