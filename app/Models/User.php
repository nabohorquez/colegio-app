<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

 protected $fillable = [
    'name',
    'first_name',
    'last_name',
    'email',
    'username',   
    'password',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Accessor para obtener nombre completo
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Sincronizar automáticamente el campo name al guardar el modelo
     */
    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->first_name || $user->last_name) {
                $user->name = trim("{$user->first_name} {$user->last_name}");
            }
        });
    }

    public function usersByRoles()
    {
        return $this->hasMany(RoleByUser::class, 'id_user', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_by_users', 'id_user', 'id_role');
    }
}
