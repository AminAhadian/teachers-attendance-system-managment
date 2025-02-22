<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'class_session_id',
        'teacher_id',
        'attendance_manager_id',
        'attendance_manager_decision',
        'head_manager_id',
        'head_manager_decision',
        'status'
    ];

    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class, 'class_session_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function attendanceManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attendance_manager_id');
    }

    public function headManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_manager_id');
    }
}
