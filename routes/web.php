<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/artisan', function (Request $request) {
    return view('artisan');
});

Route::get('/privacy-policy', function (Request $request) {
    return view('policy');
});

Route::post('/artisan-run', function (Request $request) {
    Artisan::call($request->input('command'));

    return redirect()->back()->with('success', Artisan::output());
});
