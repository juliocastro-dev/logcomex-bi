<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\UserQueryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/data/filter', [DatasetController::class, 'filter']);
    Route::get('/data/dashboard', [DatasetController::class, 'dashboard']);
    Route::get('/data/details/{id}', [DatasetController::class, 'details']);

    Route::get('/user/queries', [UserQueryController::class, 'getQueryCount']);
    // Essas rotas podem ser restritas para administradores
    Route::get('/admin/queries', [UserQueryController::class, 'listAllQueryCounts']);
    Route::post('/admin/queries/reset/{userId}', [UserQueryController::class, 'resetQueryCount']);
});
