<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

use Illuminate\Http\Request;
use App\Http\Controllers\NewsController;



Route::get('/home',[HomeController::class , 'index']) -> name('home');
Route::get('/welcome',[HomeController::class , 'index']) -> name('home');
Route::get('/',[HomeController::class , 'index']) -> name('home');
Route::redirect('/welcom', '/welcome'); // redirect ไปยังหน้า home
Route::redirect('/home', '/welcome'); // redirect ไปยังหน้า home


// Route::get('/register',[RegisteredUserController::class , 'create']) -> name('register');
// Route::get('/login',[LoginController::class , 'create']) -> name('login');

Route::get('/login', function () {
    return view('test-login');
})->name('login');


// Route::get('/login', function () {
//     return view('test-login');
// });




Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/news', function () {
    return view('news');
});




Route::get('/create-news', function () {
return view('create-news');
})->name('create.news');

Route::get('/news/{id}', function ($id) {
    return view('show', ['id' => $id]); // ส่งค่า id ไปที่ view
});

Route::get('/unlogin', function () {
    return view('unlogin'); // ใช้ชื่อไฟล์ view ที่สร้างขึ้น
});

Route::get('/edit-news/{id}', function ($id) {
    return view('edit-news', ['id' => $id]); // ส่งค่า id ไปที่ view
});





// กรณีผู้ใช้ระบุpathไม่ถูกต้อง แล้วจะตอบกลับไปยังฝั่งผู้ใช้ (client)
Route::fallback(function() {
    return "<h1>ไม่พบหน้าเว็บดังกล่าว  K  </h1>";
});
