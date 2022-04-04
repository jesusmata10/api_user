<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegister;
use App\Http\Requests\LoginRequest;
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
            "Status" => 1,
            "mensaje" => "¡Registro Realizado Sastifactoriamente!"
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::consulta2($request->email);
         
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                "status" => 1,
                "mensaje" => "¡Usuario Logueado Exitosamente!",
                "access_token" => $token
            ]);
            } else {
                return response()->json([
                    "Status" => 0,
                    "mensaje" => "¡La password no coincide!"
                ], 404);
            }
        } else {
            return response()->json([
                "Status" => 0,
                "mensaje" => "Usuario no registrado"
            ], 404);
        }
    }

    public function userProfile()
    {
    }

    public function logout()
    {
    }
}
