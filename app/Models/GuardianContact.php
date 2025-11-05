<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_id',
        'type',
        'value'
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
}
