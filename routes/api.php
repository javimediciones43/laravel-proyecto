<?php

use App\Http\Controllers\Api\AuthContoller;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Types\Relations\Role;

// Rutas de autenticación
Route::post('/login', [AuthContoller::class, 'login']);

// Rutas protegidas por sanctum
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout', [AuthContoller::class, 'logout']);
    Route::get('/user', [AuthContoller::class, 'user']);

    // Ruta de registro protegida para  administradores.
    Route::post('/register', [AuthContoller::class, 'register'])->middleware();

    // Aquí irán tus rutas CRUD para categorías, cursos, etc.
    // Ejemplo (no las crees aún, solo para que veas la estructura)
    // Route::apiResource('categories', CategoryController::class)->middleware('check.admin');
    // Route::apiResource('courses', CourseController::class)->middleware('check.admin');
    // ...
});
