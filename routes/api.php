<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_id' => 'nullable',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user) {
        throw ValidationException::withMessages([
            'message' => ['The email provided is incorrect.'],
        ]);
    }

    if (! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['The password is incorrect.'],
        ]);
    }
    $user->tokens()->delete();
    
    $token = $user->createToken($request->device_id ?: 'device_id' )->plainTextToken;

    return response()->json($token, 200);
});

Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();

    return 'Tokens are deleted';
});

Route::controller(LibraryController::class)->group(function () {
    Route::get('library', 'index');
    Route::post('library/translate', 'translate');
    Route::post('library/store', 'store');
});