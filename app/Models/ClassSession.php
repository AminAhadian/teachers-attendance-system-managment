<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'class_time_id',
        'teacher_id',
        'actual_start_time',
        'actual_end_time',
        'date',
        'teacher_enter_at',
        'teacher_exit_at',
        'teacher_delay',
        'teacher_hurry',
        'status',
        'is_active'
    ];

    protected function casts()
    {
        return [
            'is_active' => 'boolean',
            'actual_start_time' => 'datetime',
            'actual_end_time' => 'datetime',
            'teacher_enter_at' => 'datetime',
            'teacher_exit_at' => 'datetime',
        ];
    }

    public function classTime(): BelongsTo
    {
        return $this->belongsTo(ClassTime::class, 'class_time_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
