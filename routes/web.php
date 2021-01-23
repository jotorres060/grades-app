<?php

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

Route::get('/', [\App\Http\Controllers\GradeController::class, "index"])
    ->name("grades_index");

Route::get('/create-grade', [\App\Http\Controllers\GradeController::class, "create"])
    ->name("grades_create");

Route::post('/create-grade', [\App\Http\Controllers\GradeController::class, "store"])
    ->name("grades_store");

Route::get('/edit-grade/{id}', [\App\Http\Controllers\GradeController::class, "edit"])
    ->name("grades_edit")
    ->where('id', '[0-9]+');

Route::put('/edit-grade/{id}', [\App\Http\Controllers\GradeController::class, "update"])
    ->name("grades_update")
    ->where('id', '[0-9]+');

Route::delete('/destroy-grade/{id}', [\App\Http\Controllers\GradeController::class, "destroy"])
    ->name("grades_destroy")
    ->where('id', '[0-9]+');
