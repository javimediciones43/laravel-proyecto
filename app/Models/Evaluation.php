<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'score',
        'feedback',
        'evaluated_at'
    ];

    protected $casts = [
        'evaluated_at' => 'datetime'
    ];

    // Una evaluación pertenece a una inscripción.
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
