<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     * Los administradores pueden ver todas las evaluaciones.
     * Los estudiantes pueden ver sus propias evaluaciones.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $evaluations = Evaluation::with(['enrollment.user', 'enrollment.course'])->get();
        } else {
            // un estudiante no puede ver las evaluaciones de otros estudiantes.
            $evaluations = Evaluation::whereHas('enrollment', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->with(['enrollment.course'])->get();
        }

        return response()->json($evaluations, 200);
    }

    /**
     * Store a newly created resource in storage.
     * Sólo el administrador puede crear una evaluación.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permisos para crear una evaluación'
            ], 403);
        }

        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'score' => 'required|numeric|min:0|max:10',
            'feedback' => 'nullable|string|max:255',
        ]);

        $evaluation = Evaluation::create([
            'enrollment_id' => $request->enrollment_id,
            'score' => $request->score,
            'feedback' => $request->feedback,
            'evaluated_at' => now(), // Registra la fecha y hora de la evaluación.
        ]);

        return response()->json($evaluation, 201);
    }

    /**
     * Display the specified resource.
     * Accesible para administradores (cualquiera) o el estudiante propietario.
     */
    public function show(Evaluation $evaluation)
    {
        if (Auth::user()->role === 'admin' || $evaluation->enrollment->user_id === Auth::user()->id) {
            return response()->json($evaluation, 200);
        }    
    }    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $evaluation = Evaluation::findOrFail($evaluation->id);
        
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:255',
        ]);

        $evaluation->update($request->all());

        return response()->json($evaluation, 200);
    }

    /**
     * Remove the specified resource from storage.
     * Sólo accesible para el administrador.
     */
    public function destroy(Evaluation $evaluation)
    {
        if (Auth::user()->role === 'admin') {
            return response()->json([
                'message' => 'No tienes permisos para eliminar una evaluación'
            ], 403); 
        }

        $evaluation->delete();

        return response()->json(['message' => 'Evaluación eliminada correctamente'], 200);
    }
}