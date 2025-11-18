<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'nombre_grado',
        'nivel',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    /**
     * Relación: Un grado tiene muchas matrículas
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'grado_id', 'id');
    }

    /**
     * Relación: Un grado tiene muchos estudiantes
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'grade_id', 'id');
    }

    /**
     * Relación: Un grado tiene muchas materias
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grade_subject', 'grado_id', 'materia_id');
    }
}
