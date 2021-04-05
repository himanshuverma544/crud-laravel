<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::view('create','create_update');
Route::post('create',[UserController::class,'create']);
Route::get('edit/{id}',[UserController::class,'showData']);
Route::post('update',[UserController::class,'update']);
Route::post('delete',[UserController::class,'delete']);

Route::get('dashboard',[UserController::class,'show'])->name('dashboard');