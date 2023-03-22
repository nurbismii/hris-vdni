<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/new-register', [RegisterController::class, 'register'])->name('register.employee');

Auth::routes();

Route::get('/', [DashboardController::class, 'index']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::group(['prefix' => 'users'], function () {
        route::get('/', [UserController::class, 'index']);
        route::get('/create', [UserController::class, 'create']);
        route::get('/import', [UserController::class, 'import']);
        route::get('/download-example-user', [UserController::class, 'downloadExampleUser'])->name('download.exampleUser');
        route::post('/store', [UserController::class, 'store']);
        route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
        route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy.user');
    });

    Route::group(['prefix' => 'roles'], function () {
        route::get('/', [RoleController::class, 'index']);
        route::get('/create', [RoleController::class, 'create']);
        route::post('/store', [RoleController::class, 'store'])->name('store.role');
        route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit.role');
        route::patch('/update/{id}', [RoleController::class, 'update'])->name('update.role');
        route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('destroy.role');
        route::post('/add-access', [RoleController::class, 'accessUser'])->name('access');
    });

    Route::group(['prefix' => 'employees'], function () {
        route::get('/', [EmployeeController::class, 'index']);
        route::get('/create', [EmployeeController::class, 'create']);
        route::post('/store', [EmployeeController::class, 'store'])->name('store.employee');
        route::get('/import', [EmployeeController::class, 'import']);
        route::get('/download-example', [EmployeeController::class, 'downloadExample'])->name('download.example');
        route::post('/import-employee', [EmployeeController::class, 'importEmployee'])->name('import.employee');
    });

    Route::group(['prefix' => 'account'], function () {
        route::get('/profile', [AccountController::class, 'profile']);
        route::get('/billing', [AccountController::class, 'billing']);
    });
});
