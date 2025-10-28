<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'roles';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rol_name',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Get the roles by user for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolesByUsers()
    {
        return $this->hasMany(RoleByUser::class, 'id_role', 'id');
    }

    /**
     * Get the pages by role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagesByRole()
    {
        return $this->hasMany(RoleByPage::class, 'id_role', 'id');
    }
}
