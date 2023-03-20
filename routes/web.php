<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/units', [\App\Http\Controllers\UnitController::class,'index'])->name('units.index');

Route::post('/units/store', [\App\Http\Controllers\UnitController::class,'store'])->name('units.store');
