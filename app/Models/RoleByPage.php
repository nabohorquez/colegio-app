<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleByPage extends Model
{
    use HasFactory;
    protected $table = 'roles_by_pages';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id_role',
        'id_pages',
    ];

    /**
     * Get the user that owns the RolByPage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'id_pages', 'id');
    }

    /**
     * Get the role that owns the RolByPage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }
}
