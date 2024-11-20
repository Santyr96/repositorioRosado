<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::middleware('auth', 'verified')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');
});

Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email', function(){
    return view('auth.verify-email');
});

Route::get('/email/verifiy/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Enlace de verificación enviado');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
