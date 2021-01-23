<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/grades', [\App\Http\Controllers\Api\GradeController::class, "index"]);

Route::post('/grades/create', [\App\Http\Controllers\Api\GradeController::class, "store"]);

Route::put('/grades/edit/{id}', [\App\Http\Controllers\Api\GradeController::class, "update"]);

Route::delete('/grades/delete/{id}', [\App\Http\Controllers\Api\GradeController::class, "destroy"]);
