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
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use App\Http\Controllers\NewsController;

#                                                            for call
Route::get('/welcome', function () { return view('welcome'); })->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/welcom', '/welcome'); // redirect ไปยังหน้า home
Route::redirect('/home', '/welcome'); // redirect ไปยังหน้า home





Route::get('/create-news', function () {
    return view('create-news');
})->name('create.news');


Route::get('/news', function () {
    return view('news');
});
Route::get('/news/{id}', function ($id) {
    return view('show', ['id' => $id]); // ส่งค่า id ไปที่ view
});

Route::get('/login', function () {
    return view('test-login');
});

Route::get('/register', function () {
    return view('register');
});


// กรณีผู้ใช้ระบุpathไม่ถูกต้อง แล้วจะตอบกลับไปยังฝั่งผู้ใช้ (client)
Route::fallback(function() {
    return "<h1>ไม่พบหน้าเว็บดังกล่าว</h1>";
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });
