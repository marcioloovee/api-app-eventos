<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/acesso_negado', function () {
    return response([false], 401);
})->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::get('/user-profile', [\App\Http\Controllers\AuthController::class, 'userProfile']);
});

Route::post('/usuario', [\App\Http\Controllers\UsuarioController::class, 'store']);


Route::group([
    'middleware' => 'auth'
], function ($router) {
    Route::apiResource('usuario', \App\Http\Controllers\UsuarioController::class)->except(['store']);
    Route::post('usuario/{usuario}/seguir', [\App\Http\Controllers\UsuarioController::class, 'seguir']);
    Route::post('usuario/alterarFotoPerfil', [\App\Http\Controllers\UsuarioController::class, 'alterarFotoPerfil']);

    Route::apiResource('publicacao', \App\Http\Controllers\PublicacaoController::class);
    Route::post('publicacao/{publicacao}/curtir', [\App\Http\Controllers\PublicacaoController::class, 'curtir']);

    Route::apiResource('foto', \App\Http\Controllers\FotoController::class);
    Route::post('foto/{foto}/curtir', [\App\Http\Controllers\FotoController::class, 'curtir']);

    Route::apiResource('conversa', \App\Http\Controllers\ConversaController::class);
    Route::get('conversa/{usuario}/mensagens', [\App\Http\Controllers\ConversaController::class, 'mensagens']);

    Route::apiResource('evento', \App\Http\Controllers\EventoController::class);
    Route::post('evento/{evento_id}/presenca', [\App\Http\Controllers\EventoController::class, 'presenca']);
});
