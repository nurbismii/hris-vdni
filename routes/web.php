<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [DashboardController::class, 'index']);

Route::group(['middleware' => ['auth', 'audit.trails']], function () {

    Route::post('/new-register', [RegisterController::class, 'register'])->name('register.employee')->middleware('employee.registered');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/audit-trails', [DashboardController::class, 'auditTrails']);

    Route::group(['prefix' => 'setting'], function () {

        route::get('/dashboard', [DashboardController::class, 'settingDashboard']);
        route::post('/store', [DashboardController::class, 'store'])->name('store.dashboard');
        route::get('/edit/{id}', [DashboardController::class, 'edit'])->name('edit.dashboard');
        route::patch('/update/{id}', [DashboardController::class, 'update'])->name('update.dashboard');
        route::delete('/destroy/{id}', [DashboardController::class, 'destroy'])->name('destroy.dashboard');
    });

    Route::group(['prefix' => 'users'], function () {
        route::get('/', [UserController::class, 'index']);
        route::get('/create', [UserController::class, 'create']);
        route::get('/import', [UserController::class, 'import']);
        route::get('/download-example-user', [UserController::class, 'downloadExampleUser'])->name('download.exampleUser');
        route::post('/store', [UserController::class, 'store']);
        route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
        route::patch('/update/{id}', [UserController::class, 'update'])->name('update.user');
        route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy.user');
        route::get('/last-login', [UserController::class, 'lastLogin'])->name('last.login');
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
        route::post('/filter', [EmployeeController::class, 'filter']);
        route::get('/create', [EmployeeController::class, 'create']);
        route::post('/store', [EmployeeController::class, 'store'])->name('store.employee');
        route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit.employee');
        route::patch('update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
        route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy.employee');
        // Maatwebsite excel 
        route::get('/import', [EmployeeController::class, 'import']);
        route::get('/download-example', [EmployeeController::class, 'downloadExample'])->name('download.example');
        route::post('/import-employee', [EmployeeController::class, 'importEmployee'])->name('import.employee');
        route::post('/update-import-employee', [EmployeeController::class, 'updateImportEmployee'])->name('updateImport.employee');
        route::post('/destroy-import-employee', [EmployeeController::class, 'destroyImportEmployee'])->name('destroyImport.employee');
        // Maatwebsite excel end 
    });

    Route::group(['prefix' => 'account'], function () {
        route::get('/profile', [AccountController::class, 'profile']);
        route::get('/billing', [AccountController::class, 'billing']);
    });

    Route::group(['prefix' => 'salary'], function () {
        route::get('/', [SalaryController::class, 'index']);
        route::get('/history', [SalaryController::class, 'history']);
        route::post('/import-salarys', [SalaryController::class, 'importSalary'])->name('import.salary');
    });
});
