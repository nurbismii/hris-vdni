<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index']);

// Route::group(['middleware' => 'login'], function () {

Route::get('/', [DashboardController::class, 'index']);

Route::group(['prefix' => 'users'], function () {
    route::get('/', [UserController::class, 'index']);
    route::get('/create', [UserController::class, 'create']);
    route::post('/store', [UserController::class, 'store']);
    route::get('/edit', [UserController::class, 'edit']);
});

Route::group(['prefix' => 'roles'], function () {
    route::get('/', [RoleController::class, 'index']);
    route::get('/create', [RoleController::class, 'create']);
});
// });
