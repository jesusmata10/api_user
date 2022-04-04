<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegister $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'Status' => 1,
            'mensaje' => '¡Registro Realizado Sastifactoriamente!',
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::consulta2($request->email);

        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('token-name')->plainTextToken;

                return response()->json([
                    'status' => 1,
                    'mensaje' => '¡Usuario Logueado Exitosamente!',
                    'access_token' => $token,
                ]);
            }

            return response()->json([
                'Status' => 0,
                'mensaje' => '¡La password no coincide!',
            ], 404);
        }

        return response()->json([
            'Status' => 0,
            'mensaje' => 'Usuario no registrado',
        ], 404);
    }

    public function userProfile()
    {
        return response()->json([
            'status' => 0,
            'mensaje' => 'Acerca del perfil de Usuario',
            'data' => auth()->user(),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 1,
            'mensaje' => '¡Sesion Finalizada!',
        ]);
    }
}
