<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // MODO DE AUTENTICACION 1

        // if (Auth::attempt($request->only('email', 'password'))) {
        //     return response()->json([
        //         'token' => $request->user()->createToken($request->name)->plainTextToken,
        //         'message' => 'Success',
        //     ], Response::HTTP_OK);
        // }
        // return response()->json([
        //     'message' => 'The credentials are incorrect'
        // ], Response::HTTP_UNPROCESSABLE_ENTITY);

        // MODO DE AUTENTICACION 2

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash:: check($request->password, $user->password) ) {
            return response()->json([
                'message' => 'The credentials are incorrect',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'data' => [
                'attributes' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $user->createToken($request->name)->plainTextToken,
            ]
        ], Response::HTTP_OK);
    }

    public function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        ]);
    }
}