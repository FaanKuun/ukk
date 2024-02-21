<?php

use App\Http\Controllers\FotoController;
use App\Http\Controllers\UserController;
use App\Models\Foto;
use App\Models\User;
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


Route::middleware(['auth'])->group(function (){

    Route::get('/upload', function () {
    return view('page.upload');
    });

    Route::get('/album',[FotoController::class,"album"]);

    Route::post("upload",[FotoController::class,"upload"]);

    Route::get('/detail/{id}',[FotoController::class,"detail"]);

    Route::post("/coment/{id}",[FotoController::class,"coment"]);

    Route::get('/foto/delete/{id}', [FotoController::class,'hapus_foto']);

    Route::post('/like/{id}', [FotoController::class, 'like'])->name('like');
    Route::post('/unlike/{id}', [FotoController::class, 'unlike'])->name('unlike');

});


Route::get("/",[FotoController::class,"index"]);


Route::get('/register', function () {
    return view('page.register');
});

Route::post('/register', [UserController::class,'register']);


Route::get('/login', function () {
    return view('page.login');
})->name("login");

Route::post('/login', [UserController::class,'login']);

Route::get('/logout', [UserController::class,'logout']);

