<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/dashboard/hairdresser',[DashboardController::class, 'hairdresser'])->name('dashboard.hairdresser');
    Route::post('/dashboard/insertHairDresser',[DashboardController::class, 'storeHairDresser'])->name('dashboard.insertHairDresser');
    Route::get('/dashboard/services', [DashboardController::class, 'showServices'])->name('dashboard.services');
    Route::post('/dashboard/createService', [DashboardController::class, 'createService'])->name('dashboard.createService');
    Route::post('/dashboard/updateService/{serviceId}', [DashboardController::class, 'updateService'])->name('dashboard.updateService');
    Route::post('/dashboard/deleteService/{serviceId}', [DashboardController::class, 'deleteService'])->name('dashboard.deleteService');
    Route::post('/dashboard/uploadAvatar', [DashboardController::class, 'uploadAvatar'])->name('profile.uploadAvatar');
    Route::post('/dashboard/updateProfile', [DashboardController::class, 'updateProfile'])->name('profile.updateProfile');
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
    return redirect()->route('verification.notice')->with('message', 'Enlace de verificación enviado');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
