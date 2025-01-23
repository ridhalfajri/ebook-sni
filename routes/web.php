<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EbookController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');
Route::get('/login',[AuthController::class,'index_login'])->name('login');
Route::get('/register',[AuthController::class,'index_register'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('auth.register');
Route::post('/login',[AuthController::class,'login'])->name('auth.login');
Route::post('/logout',[AuthController::class,'logout'])->name('auth.logout');


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard',DashboardController::class)->name('dashboard.index');
    Route::prefix('master-data')->group(function () {
        Route::resource('/categories',CategoryController::class)->except('show','update');
        Route::post('/categories/datatable',[CategoryController::class,'datatable'])->name('categories.datatable');
        Route::post('/categories/{category}',[CategoryController::class,'update'])->name('categories.update');

        Route::resource('/ebooks',EbookController::class)->except('update');
        Route::post('/ebooks/datatable',[EbookController::class,'datatable'])->name('ebooks.datatable');
        Route::post('/ebooks/{ebook}',[EbookController::class,'update'])->name('ebooks.update');
    });
});



