<?php

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\ScopeController;

Route::post('passport/token', [AccessTokenController::class, 'issueToken'])->middleware('throttle:60,1');
Route::post('passport/token/refresh', [AccessTokenController::class, 'refreshToken']);

Route::middleware('auth:api')->group(function () {
    // Токены пользователя
    Route::get('passport/tokens', [AuthorizedAccessTokenController::class, 'forUser']);
    Route::delete('passport/tokens/{token_id}', [AuthorizedAccessTokenController::class, 'destroy']);

    // Клиенты OAuth
    Route::get('passport/clients', [ClientController::class, 'forUser']);
    Route::post('passport/clients', [ClientController::class, 'store']);
    Route::put('passport/clients/{client_id}', [ClientController::class, 'update']);
    Route::delete('passport/clients/{client_id}', [ClientController::class, 'destroy']);

    // Области действия (scopes)
    Route::get('passport/scopes', [ScopeController::class, 'all']);

    // Персональные токены
    Route::get('passport/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser']);
    Route::post('passport/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);
    Route::delete('passport/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy']);

    Route::get('passport/sessions', [SessionController::class, 'getSessions']);

    Route::delete('passport/sessions/{token_id}', [SessionController::class, 'revokeSession']);

});
