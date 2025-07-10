<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category', 'creator')->get();
        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     * Sólo accesible para administradores.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Obtener el ID del usuario autenticado (el administrador que crea el curso)
        $created_by_id = Auth::id();

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'created_by' => $created_by_id // Asignar el ID del admin autenticado.
        ]);

        return response()->json([
            'message' => 'Curso creado',
            'course' => $course
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('category', 'creator');
        return response()->json($course, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Solo accesible por administradores.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $course->update($request->all());

        return response()->json([
            'message' => 'Curso actualizado',
            'course' => $course
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * Sólo accesible para administradores.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course eliminado'
        ], 200);
    }

}
