<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'student_id',
        'subject',
        'resource_assignment',
        'example_assignment',
        'created_by'
    ];

    protected $dates = ['deleted_at'];
    
    /**
     * Relación: Una actividad pertenece a un estudiante
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
