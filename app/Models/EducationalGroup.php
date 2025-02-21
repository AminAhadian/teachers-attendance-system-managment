<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'head_id',
        'description'
    ];

    public function head(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'head_id');
    }
}
