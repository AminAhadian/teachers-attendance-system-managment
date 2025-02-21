<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'term_id',
        'location',
        'attendance_time_frame',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function term(): BelongsTo
    {
        return $this->belongsTo(TermSchedule::class, 'term_id');
    }

    public function educationalGroup(): BelongsTo
    {
        return $this->belongsTo(EducationalGroup::class, 'educational_group_id');
    }

    public function classTimes(): HasMany
    {
        return $this->hasMany(ClassTime::class, 'class_id');
    }
}
