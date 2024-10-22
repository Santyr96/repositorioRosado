<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/aboutSantiago', [HomeController::class, 'aboutSantiago'])->name('aboutSantiago');

Route::get('/login', [UserController::class, 'login'])->name('users.login');

Route::get('/create', [UserController::class, 'create'])->name('users.create');

Route::post('/store', [UserController::class, 'store'])->name('users.store');


