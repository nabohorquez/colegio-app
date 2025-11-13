<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollments';

    protected $fillable = [
        'estudiante_id',
        'grado_id',
        'tipo_matricula_id',
        'forma_pago',
        'fecha',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'estado' => 'boolean'
    ];

    /**
     * Relación: Una matrícula pertenece a un estudiante
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'estudiante_id', 'id');
    }

    /**
     * Relación: Una matrícula pertenece a un grado
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grado_id', 'id');
    }

    /**
     * Relación: Una matrícula tiene un tipo de matrícula
     */
    public function enrollmentType()
    {
        return $this->belongsTo(EnrollmentType::class, 'tipo_matricula_id', 'id');
    }
}
