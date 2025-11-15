<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'subject',
        'academic_period',
        'first_partial',
        'second_partial',
        'final_grade',
        'notes',
        'created_by',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Relationship: A grade belongs to a student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship: A grade is created by a user (teacher/admin)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accessor: Calculate average partial grade
     */
    public function getAveragePartialAttribute()
    {
        if ($this->first_partial && $this->second_partial) {
            return round(($this->first_partial + $this->second_partial) / 2, 2);
        }
        return null;
    }

    /**
     * Accessor: Determine if student passed
     */
    public function getStatusAttribute()
    {
        if ($this->final_grade === null) {
            return 'pending';
        }
        return $this->final_grade >= 3 ? 'passed' : 'failed';
    }
}
