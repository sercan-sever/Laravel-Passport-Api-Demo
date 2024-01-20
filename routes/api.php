<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Auth
Route::controller(AuthController::class)->middleware(['not.logged.in.api', 'throttle:api'])->group(function () {
    Route::post('/v1/login', 'login')->name('v1.login');
    Route::post('/v1/register', 'register')->name('v1.register');
    Route::post('/v1/forgot-password', 'forgotPassword')->name('v1.forgot.password');
    Route::post('/v1/reset-password', 'resetPassword')->name('v1.reset.password');
});


Route::prefix('v1')->middleware(['auth:api'])->name('v1.')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // Product
    Route::controller(ProductController::class)->group(function () {

        // List
        Route::get('/product/list', 'productListAll')->name('product.list.all');
        Route::get('/product/list/active', 'productListActive')->name('product.list.active');
        Route::get('/product/list/passive', 'productListPassive')->name('product.list.passive');
        Route::get('/product/{id}/detail', 'productDetail')->name('product.detail');

        // CRUD
        Route::post('/product/create', 'create')->name('product.create');
        Route::post('/product/update', 'update')->name('product.update');
        Route::post('/product/update/status', 'updateStatus')->name('product.update.status');
        Route::post('/product/update/image', 'updateImage')->name('product.update.image');

        Route::get('/product/{id}/delete', 'productDelete')->name('product.delete');
    });
});
