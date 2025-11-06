<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianStudent extends Model
{
    use HasFactory;

    // Nombre de la tabla pivot
    protected $table = 'guardian_student';

    // La tabla pivot en tu migración tiene timestamps, así que los dejamos activos
    public $timestamps = true;

    // Campos asignables
    protected $fillable = [
        'guardian_id',
        'student_id',
        'relationship', // Padre, Madre, Otro
    ];

    // Relaciones útiles (opcional)
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
