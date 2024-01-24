<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

// app/Models/User.php


class User extends Authenticatable
{
    use HasApiTokens;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        "lastname",
        'email',
        'password',
        'username',
        'role',
        "student_no",
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isMemberEtikKurul()
    {
        return $this->role == 'admin' || $this->role == 'sekreterlik' || $this->role == 'etik_kurul';
    }
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // New method to check if the user has any of the specified roles
    public function hasAnyRole($roles)
    {
        return in_array($this->role, $roles);
    }
    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
