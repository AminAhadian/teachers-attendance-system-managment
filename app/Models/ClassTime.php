<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassTime extends Model
{
    protected $fillable = [
        'class_id',
        'day',
        'start_time',
        'end_time',
        'type'
    ];

    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class, 'class_id');
    }
}
