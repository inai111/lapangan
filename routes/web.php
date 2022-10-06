<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::controller(Home::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::post('/login', 'login');
    Route::post('/regist', 'register');
    Route::get('/logout', 'logout');
});
Route::controller(Dashboard::class)->group(function(){
    Route::get('/dashboard', 'index')->middleware('auth');
    Route::get('/settings', 'setting')->middleware('auth');
    Route::post('/settings', 'settingStore')->middleware('auth');
    Route::get('/merchant-regist', 'merchant_register')->middleware('auth');
    // Route::post('/login', 'login');
    // Route::post('/regist', 'register');
});
// Route::post('/login', function(){
//     return response()->json([new Request()]);
// });
