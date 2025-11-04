<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrollmentType extends Model
{
    use HasFactory, SoftDeletes;

    // Nombre de la tabla si quieres ser explícito (opcional)
    protected $table = 'enrollment_types';

    // Campos asignables en masa
    protected $fillable = [
        'name',
        'code',
        'description',
        'fee',
        'is_active',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
