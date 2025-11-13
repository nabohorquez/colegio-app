<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'nombre_materia',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    /**
     * Relación: Una materia tiene muchos profesores (through pivot)
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_subject', 'materia_id', 'employee_id');
    }

    /**
     * Relación: Una materia tiene muchos estudiantes (through pivot)
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'materia_id', 'estudiante_id');
    }

    /**
     * Relación: Una materia pertenece a muchos grados
     */
    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_subject', 'materia_id', 'grado_id');
    }
}
