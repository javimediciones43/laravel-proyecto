<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo administradores o el propio usuario pueden ver sus inscripciones
        if (Auth::user()->role === 'admin') {
            $enrollment = Enrollment::with(['user', 'course'])->get();
        } else {
            // Un estudiante solo puede ver sus propias inscripciones
            $enrollment = Auth::user()->enrollments()->with(['course'])->get();
        }

        return response()->json($enrollment, 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        // Validar que no se haya inscripto antes
        $yaInscripto = Enrollment::where('user_id', $request->user()->id)
                                 ->where('course_id', $request->course_id)->exists();

        if ($yaInscripto){
            return response()->json([
                'message' => 'ya estás inscripto en este curso'
            ], 409);
        }

        $enrollment = Enrollment::create([
            'user_id' => $request->user()->id,
            'course_id' => $request->course_id,
            'enrolled_at' => now()
        ]);

        return response()->json($enrollment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
