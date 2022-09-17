<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Metodo que recibe el formulario
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'token' => $request->user()->createToken($request->name)->plainTextToken,
                'message' => 'Success'
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    // Metodo que verifica que llegue la informacion correctamente
    public function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required' // Nombre del dispositivo
        ]);
    }
}
