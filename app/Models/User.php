<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'teacher') {
            return $this->hasRole('teacher');
        } else if ($panel->getId() === 'headManager') {
            return $this->hasRole('headManager');
        } else if ($panel->getId() === 'attendanceManager') {
            return $this->hasRole('attendanceManager');
        }
        return true;
    }

    protected $fillable = [
        'name',
        'username',
        'email',
        'gender',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }
}
