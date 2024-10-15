<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/unlogin', function () {
    return view('unlogin'); // ใช้ชื่อไฟล์ view ที่สร้างขึ้น
});
Route::get('/edit-news/{id}', function ($id) { 
    return view('edit-news', ['id' => $id]); // ส่งค่า id ไปที่ view
});


# sample
// Route::controller(PostController::class)
//     ->prefix('posts')
//     ->group(callback:  function () {
//         Route::get('', 'index');
//         Route::post('', 'store');
//         Route::post('delete', 'delete');
//         Route::post('restore-all-trashed', 'restoreAllTrashed');
//         Route::post('force-delete-trashed', 'forceDeleteTrashed');
//         Route::get('{id}', 'show');
//         Route::put('{id}', 'update');
//         Route::put('{id}/status-change/{column}', 'changeStatusOtherColumn'); //specific columns change value from 0 to 1 and vice versa
//         Route::put('{id}/status-change', 'changeStatus');//default status column from 0 to 1 and vice versa
//         Route::put('{id}/restore-trash', 'restoreTrashed');
//         Route::delete('{id}', 'destroy');
//     });




// กรณีผู้ใช้ระบุpathไม่ถูกต้อง แล้วจะตอบกลับไปยังฝั่งผู้ใช้ (client)
Route::fallback(function() {
    return "<h1>ไม่พบหน้าเว็บดังกล่าว</h1>";
});

