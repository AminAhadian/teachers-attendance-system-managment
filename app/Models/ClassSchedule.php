<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'name',
        'code',
        'presentation_code',
        'educational_group_id',
        'term_schedule_id',
        'location',
        'attendance_time_frame',
        'start_date',
        'end_date',
        'is_active',
    ];
}
