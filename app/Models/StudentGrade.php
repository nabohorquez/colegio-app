<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentGrade extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_grades';

    protected $fillable = [
        'student_id',
        'subject_id',
        'partial_1',
        'partial_2',
        'final_grade',
        'observations',
        'created_by'
    ];

    protected $casts = [
        'partial_1' => 'float',
        'partial_2' => 'float',
        'final_grade' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * ✅ Relación: Una calificación pertenece a un estudiante
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    /**
     * ✅ Relación: Una calificación pertenece a una asignatura
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    /**
     * ✅ Relación: Una calificación fue creada por un usuario
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * ✅ Accessor: Obtener el estado de la calificación
     */
    public function getStatusAttribute()
    {
        if (is_null($this->final_grade)) {
            return 'PENDIENTE';
        }
        return $this->final_grade >= 3.0 ? 'APROBADO' : 'REPROBADO';
    }

    /**
     * ✅ Accessor: Obtener promedio de parciales
     */
    public function getAveragePartialAttribute()
    {
        if ($this->partial_1 && $this->partial_2) {
            return round(($this->partial_1 + $this->partial_2) / 2, 2);
        }
        return null;
    }
}
