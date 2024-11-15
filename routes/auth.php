<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/**
 * Creamos la ruta para el login de usuarios. Todas las rutas serán controladas por el
 * middleware de autenticación.
 */
Route::middleware('guest', 'web')->group(function () {

    Route::get('/login', [UserController::class, 'login'])->name('users.login');
    Route::post('/loginUser', [UserController::class, 'loginEntrance'])->name('users.loginUser');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');
});
