<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

// require __DIR__.'/auth.php';
Auth::routes();

# all of this to get homepage
Route::get('/', function () {
    return view('home');
})->name('home');

# all of this to get homepage
Route::get('/welcome', function () {
    return view('home');
})->name('home');

# all of this to get homepage
Route::get('/home', function () {
    return view('home');
})->name('home');



// Route::redirect('/home', '/welcome'); // redirect ไปยังหน้า home
// Route::redirect('/home', '/'); // redirect ไปยังหน้า home

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// กรณีผู้ใช้ระบุpathไม่ถูกต้อง แล้วจะตอบกลับไปยังฝั่งผู้ใช้ (client)
Route::fallback(function() {
    return "<h1>ไม่พบหน้าเว็บดังกล่าว</h1>";
});



