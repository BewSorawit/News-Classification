<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/home',[HomeController::class , 'index']) -> name('home');
Route::get('/welcome',[HomeController::class , 'index']) -> name('home');
Route::get('/',[HomeController::class , 'index']) -> name('home');

Route::get('/register',[RegisteredUserController::class , 'create']) -> name('register');
Route::get('/login',[LoginController::class , 'index']) -> name('login');

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });
