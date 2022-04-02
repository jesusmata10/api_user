<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            "Status" => 1,
            "mensaje" => "¡Registro Realizado Sastifactoriamente!"
        ]);

    }

    public function login(Request $request)
    {
    }

    public function userProfile()
    {
    }

    public function logout()
    {
    }
}
