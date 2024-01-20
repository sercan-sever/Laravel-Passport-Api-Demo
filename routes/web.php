<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return "Giriş Sayfasına Hoşgeldiniz !!!";
})->name('login');

Route::get('/reset-password/{token}', function (string $token) {
    return "Yeni Şifre Belirleme Sayfasına Hoşgeldiniz !!! ( ". $token ." )"  ;
})->name('reset.password');
