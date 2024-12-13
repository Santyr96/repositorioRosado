<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalendarController;
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
    //Ruta inicial que carga el dashboard.
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');

    //Ruta que se encarga de manejar el cierre de sesión por parte del usuario.
    Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');

    //Rutas de la vista de edición de perfil.
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/dashboard/uploadAvatar', [DashboardController::class, 'uploadAvatar'])->name('profile.uploadAvatar');
    Route::post('/dashboard/updateProfile', [DashboardController::class, 'updateProfile'])->name('profile.updateProfile');

    //Rutas que se encarga de la gestión de los servicios de la peluqueria.
    Route::get('/dashboard/services', [DashboardController::class, 'showServices'])->name('dashboard.services');
    Route::post('/dashboard/createService', [DashboardController::class, 'createService'])->name('dashboard.createService');
    Route::post('/dashboard/updateService/{serviceId}', [DashboardController::class, 'updateService'])->name('dashboard.updateService');
    Route::post('/dashboard/deleteService/{serviceId}', [DashboardController::class, 'deleteService'])->name('dashboard.deleteService');
    
    //Rutas que se encarga de la gestión de las peluquerias.
    Route::get('/dashboard/hairdresser',[DashboardController::class, 'hairdresser'])->name('dashboard.hairdresser');
    Route::post('/dashboard/insertHairDresser',[DashboardController::class, 'storeHairDresser'])->name('dashboard.insertHairDresser');

    //Rutas que se encargan de las gestión de las altas de los clientes a las peluquerias.
    Route::get('/dashboard/signUp/hairdresser', [DashboardController::class, 'showHairdressers'])->name('dashboard.showHairdressers');
    Route::post('/dashboard/signUp/hairdresser/store',[DashboardController::class, 'signupHairdresser'])->name('dashboard.signupHairdresser');

    //Rutas que se encargan de mostrar el calendario.
    Route::get('/dashboard/select/signup', [CalendarController::class, 'findSignup'])->name('dashboard.selectSignup');
    Route::post('/dashboard/calendar', [CalendarController::class, 'showCalendar'])->name('dashboard.showCalendar');

    //Rutas que se encargan de la gestión de las citas.
    Route::post('/dashboard/calendar/appointments', [AppointmentController::class, 'clientIndex'])->name('dashboard.clientAppointments');
    Route::post('/dashboard/calendar/appointments/create', [AppointmentController::class, 'storeAppointment'])->name('dashboard.storeAppointment');
    Route::post('/dashboard/calendar/appointments/update', [AppointmentController::class, 'updateAppointment'])->name('dashboard.updateAppointment');
    Route::post('/dashboard/calendar/appointments/delete', [AppointmentController::class, 'deleteAppointment'])->name('dashboard.deleteAppointment');
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
