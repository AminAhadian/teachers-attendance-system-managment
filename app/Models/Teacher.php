<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'degree_id',
        'academic_field_id',
        'personnel_code',
        'attendance_code',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
    public function academicField(): BelongsTo
    {
        return $this->belongsTo(AcademicField::class, 'academic_field_id');
    }
}
