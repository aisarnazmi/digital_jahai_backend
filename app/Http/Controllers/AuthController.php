<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_id' => 'nullable',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'message' => ['The email provided is incorrect.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The password is incorrect.'],
            ]);
        }
        $user->tokens()->delete();

        $token = $user->createToken($request->device_id ?: 'device_id')->plainTextToken;

        return response()->json($token, 200);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return 'Tokens are deleted';
    }
}
