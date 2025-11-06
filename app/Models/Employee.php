<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'marital_status'
    ];

    /**
     * Relación con el usuario
     * employee.user_id → users.id
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relación con contactos del empleado
     * employee_contacts.employee_id → employees.id
     */
    public function contacts()
    {
        return $this->hasMany(EmployeeContact::class, 'employee_id', 'id');
    }
}
