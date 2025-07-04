<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthContoller extends Controller
{
    // register

    /**
     * Registro de un nuevo usuario (solo admin)
     */
    public function register(Request $request) 
    {
        // Verificar si el usuario autenticado es un administrador.
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Acceso no autorizado' 
            ]);
        }
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user'  => $user
        ], 201);
    }

    // login
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt($request->only('email', 'password'))) {
           return response()->json([
            'message' => 'Credenciales Inválidas'
           ], 401);
        }

        $user = Auth::user(); 

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
            'user' => $user
        ]);
    }

    // logout
    public function logout(Request $request) 
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Sesión cerrada'
        ]);
    }

    /**
     * Obtener información del usuario autenticado.
     */
    public function user(Request $request)
    {
        return response()->json([
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'role' => $request->user()->role,
        ], 200);
    }
}
