<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    // Una inscripción pertenece a un curso.
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Una inscripción pertenece a un usuario.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una inscripcion puede tener una evaluación.
    public function evaluation()
    {
        return $this->hasOne(Evaluation::class);
    }   
}
