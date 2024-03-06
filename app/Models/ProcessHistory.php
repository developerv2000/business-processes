<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessHistory extends Model
{
    use HasFactory;

    const STATUS_UPDATE_ACTION_NAME = 'status-update';

    protected $guarded = ['id'];
    public $timestamps = false;

    protected $with = [
        'newStatus',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // getNewStatusIdAttribute() accessor is used to avoid JSON relationship bind problems
    public function newStatus()
    {
        return $this->belongsTo(ProcessStatus::class, 'new_status_id');
    }

    public function getNewStatusIdAttribute()
    {
        return $this->options['new_status_id'] ?? null;
    }

    public function process()
    {
        return $this->belongsTo(Process::class)->withTrashed();
    }

    // ********** Events **********
    protected static function booted(): void
    {
        static::creating(function ($item) {
            $item->created_at = now();
        });
    }
}
