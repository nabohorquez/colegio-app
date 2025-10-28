<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permission',
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
     * Get the pages by permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function pageByPermission()
    {
        return $this->hasMany(RoleByPage::class, 'id_permission', 'id');
    }
}
