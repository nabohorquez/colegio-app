<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentType extends Model
{
    use HasFactory;

    protected $table = 'enrollment_types';

    protected $fillable = [
        'nombre_tipo',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    /**
     * Relación: Un tipo de matrícula tiene muchas matrículas
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'tipo_matricula_id', 'id');
    }
}
