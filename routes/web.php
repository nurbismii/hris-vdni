<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LokasiAbsenController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WaktuAbsenController;
use App\Models\Departemen;
use App\Models\WaktuAbsen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/new-register', [RegisterController::class, 'register'])->name('register.employee')->middleware('employee.registered');
Auth::routes();
Route::post('/get-lokasi', [DashboardController::class, 'getLocation']);
Route::get('/', [DashboardController::class, 'index']);

Route::group(['middleware' => ['auth', 'audit.trails']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/audit-trails', [DashboardController::class, 'auditTrails']);
    Route::post('/store/absen', [WaktuAbsenController::class, 'storeAbsen'])->name('store.absen');

    Route::group(['prefix' => 'setting'], function () {
        route::get('/dashboard', [DashboardController::class, 'settingDashboard']);
        route::post('/store', [DashboardController::class, 'store'])->name('store.dashboard');
        route::get('/edit/{id}', [DashboardController::class, 'edit'])->name('edit.dashboard');
        route::patch('/update/{id}', [DashboardController::class, 'update'])->name('update.dashboard');
        route::delete('/destroy/{id}', [DashboardController::class, 'destroy'])->name('destroy.dashboard');

        route::get('/waktu-absen', [WaktuAbsenController::class, 'index']);
        route::post('/store/waktu-absen', [WaktuAbsenController::class, 'storeWaktuAbsen'])->name('store.waktu_absen');
        route::patch('/update/waktu-absen/{id}', [WaktuAbsenController::class, 'update'])->name('update.waktu_absen');
        route::delete('/delete/waktu-absen/{id}', [WaktuAbsenController::class, 'destroy'])->name('delete.waktu_absen');

        route::get('/lokasi-absen', [LokasiAbsenController::class, 'index']);
        route::post('/store/lokasi-absen', [LokasiAbsenController::class, 'store'])->name('store.lokasi');
        route::patch('/update/lokasi-absen/{id}', [LokasiAbsenController::class, 'update'])->name('update.lokasi');
        route::delete('/delete/lokasi-absen/{id}', [LokasiAbsenController::class, 'destroy'])->name('delete.lokasi');
    });

    Route::group(['prefix' => 'users'], function () {
        route::get('/', [UserController::class, 'index']);
        route::get('/create', [UserController::class, 'create']);
        route::post('/store', [UserController::class, 'store']);
        route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
        route::patch('/update/{id}', [UserController::class, 'update'])->name('update.user');
        route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy.user');

        route::get('/download-example-user', [UserController::class, 'downloadExampleUser'])->name('download.exampleUser');
        route::get('/import', [UserController::class, 'import']);
        route::post('/import-user', [UserController::class, 'importUser'])->name('import.user');
        route::get('/last-login', [UserController::class, 'lastLogin'])->name('last.login');
        route::get('/server-side', [UserController::class, 'serverSide']);
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
        // route::post('/store', [EmployeeController::class, 'store'])->name('store.employee');
        // route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit.employee');
        route::patch('update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
        route::get('/show/{nik}', [EmployeeController::class, 'show'])->name('employee.show');
        route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy.employee');
        route::get('/server-side', [EmployeeController::class, 'serverSideEmployee']);
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
        route::get('/information', [AccountController::class, 'billing']);
        route::get('/invoice/{id}', [AccountController::class, 'show'])->name('invoice');
        route::patch('/update/{id}', [AccountController::class, 'update'])->name('account.update');
        route::get('/contract', [AccountController::class, 'contract'])->name('contract');
        route::get('/slip-gaji/{id}', [AccountController::class, 'cetak_pdf'])->name('slipgaji');
    });

    Route::group(['prefix' => 'salary'], function () {
        route::get('/', [SalaryController::class, 'index']);
        route::get('/history', [SalaryController::class, 'history']);
        route::get('/export-template', [SalaryController::class, 'exportSalary'])->name('export.salary');
        route::get('/slip-gaji', [SalaryController::class, 'slipgaji'])->name('salary.slipgaji');
        route::post('/import-salarys', [SalaryController::class, 'importSalary'])->name('import.salary');
        route::get('/server-side', [SalaryController::class, 'sideServer']);
        route::get('/show/{id}', [SalaryController::class, 'show'])->name('payslip.show');
    });

    Route::group(['prefix' => 'contract'], function () {
        route::get('/', [ContractController::class, 'index']);
        route::get('/server-side', [ContractController::class, 'serverSide']);
        route::post('/import-pkwt', [ContractController::class, 'importContract']);
        route::post('/destroy-import-pkwt', [ContractController::class, 'destroyImportContract'])->name('destroyImport.contract');
        route::get('/show/{nik}', [ContractController::class, 'show'])->name('contract.show');
    });

    Route::group(['prefix' => 'departemen'], function () {
        route::get('/', [DepartemenController::class, 'index']);
        route::post('/store', [DepartemenController::class, 'store'])->name('departemen.store');
        route::patch('/update/{id}', [DepartemenController::class, 'update'])->name('departemen.update');
        route::delete('/destroy/{id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');
        route::get('/{id}/divisi', [DepartemenController::class, 'divisi'])->name('departemen.divisi');
    });

    Route::group(['prefix' => 'divisi'], function () {
        route::post('/store', [DivisiController::class, 'store'])->name('store.divisi');
        route::delete('/destroy/{id}', [DivisiController::class, 'destroy'])->name('destroy.divisi');
        route::patch('/update/{id}', [DivisiController::class, 'update'])->name('update.divisi');
        route::get('/export-divisi', [DivisiController::class, 'exportDivisi'])->name('export.div');
    });

    Route::group(['prefix' => 'absen'], function () {
        route::get('/', [AbsensiController::class, 'index']);
        route::post('/store', [AbsensiController::class, 'store'])->name('store.absensi');
        route::patch('/update/{id}', [AbsensiController::class, 'update'])->name('update.absensi');
    });
});
