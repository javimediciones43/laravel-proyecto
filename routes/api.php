<?php

use App\Http\Controllers\Api\AuthContoller;
use App\Http\Controllers\CategoryController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Types\Relations\Role;
use App\Http\Middleware\CheckRole;

// Rutas de autenticación
Route::post('/login', [AuthContoller::class, 'login']);

// Rutas protegidas por sanctum
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout', [AuthContoller::class, 'logout']);
    Route::get('/user', [AuthContoller::class, 'user']);

    // Ruta de registro protegida para  administradores.
    Route::post('/register', [AuthContoller::class, 'register']);

    // Aquí irán tus rutas CRUD para categorías, cursos, etc.
    Route::apiResource('categories', CategoryController::class);
    // Route::apiResource('courses', CourseController::class)->middleware('check.admin');
    // ...
});
