<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'created_by',
    ];

    // Un curso pertence a una categoría.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Un curso es creado por un usuario.
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Un curso puede tener muchas inscripciones
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
