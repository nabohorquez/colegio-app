<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

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
     * Get the roles by pages for the Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolesByPages()
    {
        return $this->hasMany(RoleByPage::class, 'id_page', 'id');
    }

    /**
     * Get the father pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fatherPage()
    {
        return $this->belongsTo(Page::class, 'id_father_page', 'id');
    }

    /**
     * Get the page type for Page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pageType()
    {
        return $this->belongsTo(PageType::class, 'id_page_type', 'id');
    }
}
