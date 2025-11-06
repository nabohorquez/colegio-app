<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'second_name',
        'last_name',
        'second_last_name',
        'email',
        'gender',
        'marital_status'
    ];

    /** ✅ Un acudiente tiene muchos contactos */
    public function contacts()
    {
        return $this->hasMany(GuardianContact::class);
    }

    /** ✅ Un acudiente tiene muchos estudiantes (1:N) */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /** ✅ Nombre completo en un solo atributo */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->second_name} {$this->last_name} {$this->second_last_name}");
    }
}
