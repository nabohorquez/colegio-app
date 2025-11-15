<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'document',
        'grade',
        'guardian_id',
        'institutional_email'
    ];

    /**
     * ✅ Accessor para obtener nombre completo
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * ✅ Relación: cada estudiante pertenece a 1 acudiente
     */
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    /**
     * Relación: un estudiante tiene muchas calificaciones
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * ✅ Evento al crear estudiante: genera correo institucional
     */
    protected static function booted()
    {
        static::creating(function ($student) {
            if (!$student->institutional_email) {

                // construir correo base: nombre.apellido
                $base = strtolower(
                    str_replace(' ', '', $student->first_name) . '.' .
                    str_replace(' ', '', $student->last_name)
                );

                $domain = 'academicsoft.com';
                $email = "{$base}@{$domain}";
                $counter = 1;

                // evitar duplicados: agrega número si existe
                while (self::where('institutional_email', $email)->exists()) {
                    $email = "{$base}{$counter}@{$domain}";
                    $counter++;
                }

                $student->institutional_email = $email;
            }
        });
    }
}
