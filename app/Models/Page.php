<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\RoleByPage;

class Page extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'pages';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_name',
        'description',
        'route',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'id_page_type',
        'id_father_page',
    ];

    /**
     * Get the role by pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleByPage()
    {
    // foreign key on roles_by_pages is id_page, local key is id
    return $this->hasMany(RoleByPage::class, 'id_page', 'id');
    }

    /**
     * Get the Page Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pageType()
    {
        return $this->belongsTo(PageType::class, 'id_page_type', 'id');
    }

    /**
     * Get the father By Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fatherByPage()
    {
        return $this->belongsTo(Page::class, 'id_father_page', 'id');
    }

    /**
     * Get the Pages by Father page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pageByFather()
    {
        // children pages where their id_father_page equals this page id
        return $this->hasMany(Page::class, 'id_father_page', 'id');
    }
}
