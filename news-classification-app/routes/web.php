<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;


#                                                            for call
Route::get('/welcome', function () { return view('welcome'); })->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/welcom', '/welcome'); // redirect ไปยังหน้า home
Route::redirect('/home', '/welcome'); // redirect ไปยังหน้า home


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

