<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleByPage extends Model
{
    protected $table = 'roles_by_pages';

    // This is a pivot-like table with a composite primary key.
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_role',
        'id_page',
        'id_permission',
    ];

    /**
     * Get the Pages by Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pageByRole()
    {
        return $this->belongsTo(Page::class, 'id_page', 'id');
    }

    /**
     * Get the Role by Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleByPage()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    /**
     * Get the Permission by Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissionByPage()
    {
        return $this->belongsTo(Permission::class, 'id_permission', 'id');
    }
}
