<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Contracts\Cache\Store;
use App\Http\Controllers\EvaluationController;


// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por sanctum
Route::middleware(['auth:sanctum', 'role:admin'])->group(function (){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);


    // Ruta de registro protegida para  administradores.
    Route::post('/register', [AuthController::class, 'register']);

    // Aquí irán tus rutas CRUD para categorías, cursos, etc.
    // Categorias
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('enrollments', EnrollmentController::class)->only(['index', 'store']); // El estudiante sólo puede ver sus incripciones y hacer nuevas.
    Route::apiResource('evaluations', EvaluationController::class)->only(['store', 'update', 'destroy']); // El administrador puede ver todas las evaluaciones, actualizarlas y eliminarlas.
});
