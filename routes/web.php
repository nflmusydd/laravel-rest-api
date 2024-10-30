<?php

use App\Http\Controllers\Admin\Admin_loginController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('showloginform');
});

Route::middleware('admin')->group(function(){
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::post('store', [UserController::class, 'store'])->name('new_user');
    Route::get('create', [UserController::class, 'create'])->name('user.create');
    Route::get('user-delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    // Route::apiResource('business', BusinessController::class)->name('index', 'businesses');
    Route::get('businesses', [BusinessController::class, 'index'])->name('businesses');
    Route::post('business-store', [BusinessController::class, 'store'])->name('new_business');
    Route::get('business-create', [BusinessController::class, 'create'])->name('business.create');
    Route::get('business-delete/{id}', [BusinessController::class, 'destroy'])->name('business.delete');
});

Route::get('showloginform', [Admin_loginController::class, 'showloginform']);
Route::post('admin_login',[Admin_loginController::class, 'login'])->name('admin_login');
Route::post('showloginform',[Admin_loginController::class, 'showloginform'])->name('showloginform');
Route::get('logout',[Admin_loginController::class, 'logout'])->name('logout');
