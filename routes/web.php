<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import controllers
use App\Http\Controllers\{
    AccountController,
    ApiController,
    Auth\ForgotPasswordController,
    Auth\RegisterController,
    Auth\ResetPasswordController,
    DepartemenController,
    KaryawanRosterController,
    LemburController,
    SalaryController,
    WilayahController
};

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\PermohonanCutiController;
use App\Http\Controllers\Admin\ResignController;
use App\Http\Controllers\Admin\ReportSpController;
use App\Http\Controllers\Admin\SeverancepayController;

use App\Http\Controllers\SelfService\CutiIzinController;
use App\Http\Controllers\SelfService\CutiTahunanController;
use App\Http\Controllers\SelfService\CutiRosterController;
use App\Http\Controllers\SelfService\IzinTidakBerbayarController;
use App\Http\Controllers\SelfService\SlipGajiController;
use App\Http\Controllers\SelfService\LemburController as SelfServiceLemburController;
use App\Http\Controllers\SelfService\StatusPengajuanController;
use App\Http\Controllers\SelfService\TiketController;
use App\Http\Controllers\SelfService\AbsensiController;

Route::get('/konfirmasi/{id}', [RegisterController::class, 'konfirmasiEmail'])->name('email.confirm');
Route::get('/lupa-kata-sandi', [ForgotPasswordController::class, 'index']);
Route::post('/reset-kata-sandi', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');
Route::get('/set-kata-sandi/{id}', [ResetPasswordController::class, 'setPassword'])->name('set.password');
Route::patch('/update/kata-sandi/{id}', [ResetPasswordController::class, 'updatePassword'])->name('update.password');

Auth::routes();

Route::post('/new-register', [RegisterController::class, 'register'])->name('register.employee')->middleware('employee.registered');
Route::get('/', [DashboardController::class, 'index'])->middleware('email.verify');

Route::group(['middleware' => ['auth', 'audit.trails', 'email.verify']], function () {

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('fetch-kabupaten/{id}', [DashboardController::class, 'fetchKabupaten']);
        Route::get('fetch-kecamatan/{id}', [DashboardController::class, 'fetchKecamatan']);
        Route::get('fetch-kelurahan/{id}', [DashboardController::class, 'fetchKelurahan']);
    });

    // ROUTE GROUP BAGIAN ADMIN
    Route::group(['middleware' => 'isAdmin'], function () {

        Route::get('/audit-trails', [DashboardController::class, 'auditTrails']);

        Route::group(['prefix' => 'pengajuan-karyawan'], function () {
            route::get('/update/status-diterima/{id}', [PermohonanCutiController::class, 'updateStatusPengajuanDiterima'])->name('update.statuspengajuan.diterima');
            route::get('/update/status-ditolak/{id}', [PermohonanCutiController::class, 'updateStatusPengajuanDitolak'])->name('update.statuspengajuan.ditolak');
            route::get('/destroy/{id}', [PermohonanCutiController::class, 'pengajuanKaryawanDestroy'])->name('pengajuan-karyawan/destroy');
        });

        // USER AND ROLE MANAGEMENT
        Route::group(['prefix' => 'users'], function () {
            route::get('/last-login', [UserController::class, 'lastLogin'])->name('users.lastLogin');
            route::get('/server-side', [UserController::class, 'serverSide']);
        });
        Route::resource('users', 'App\Http\Controllers\Admin\UserController');
        Route::resource('roles', 'App\Http\Controllers\Admin\RoleController');
        Route::post('roles/add-access', [RoleController::class, 'accessUser'])->name('access');
        // END USER AND ROLE MANAGEMENT

        Route::group(['prefix' => 'kompensasi-dan-keuntungan', 'middleware' => ['sec.comben']], function () {

            route::get('/cuti-izin', [PermohonanCutiController::class, 'index']);
            route::get('/cuti-izin/server-side', [PermohonanCutiController::class, 'serverSidePengajuan']);
            
            route::get('/cuti-roster', [PermohonanCutiController::class, 'cutiRoster']);
            route::get('/cuti-roster/server-side', [PermohonanCutiController::class, 'serverSideCutiRoster']);
            route::get('/cuti-roster/detail/{id}', [PermohonanCutiController::class, 'cutiRosterShow'])->name('cutiroster.show');
            route::post('/cuti-roster/update/{id}', [PermohonanCutiController::class, 'cutiRosterUpdate'])->name('cutiroster.update');
            route::get('/cuti-roster/create', [PermohonanCutiController::class, 'cutiRosterCreate'])->name('cutiroster.create');

            route::get('/pengingat', [KaryawanRosterController::class, 'reminder']);
            route::get('/kalender', [KaryawanRosterController::class, 'index']);

            route::get('/lembur', [LemburController::class, 'lembur']);
            route::get('/lembur/list', [LemburController::class, 'serverSideLemburAll']);
            route::get('/lembur/show/{id}', [LemburController::class, 'lemburShow'])->name('lembur.show.hr');
        });

        Route::group(['prefix' => 'salary'], function () {
            route::get('/', [SalaryController::class, 'index']);
            route::get('/server-side', [SalaryController::class, 'serverSideSalary']);
            route::get('/employee', [SalaryController::class, 'gajikaryawan'])->name('salary.employee');
            route::get('/payslip/print/{id}', [SalaryController::class, 'printPayslip'])->name('payslip.print');
            route::get('/show/{id}', [SalaryController::class, 'show'])->name('salary.show');
        });

        // SETTINGS ROUTE GROUP 
        Route::group(['prefix' => 'setting'], function () {
            route::resource('dashboard-widgets', 'App\Http\Controllers\Admin\DashboardWidgetController');
            route::resource('waktu-absen', 'App\Http\Controllers\Admin\WaktuAbsenController');
            route::resource('lokasi-absen', 'App\Http\Controllers\Admin\LokasiAbsenController');
            route::resource('pasal', 'App\Http\Controllers\Admin\PasalController');
            route::resource('periode-roster', 'App\Http\Controllers\Admin\PeriodeRosterController');
        });
        //

        // EMPLOYEE ROUTE GROUP
        // TIDAK DAPAT DIGANTI MENJADI RESOURCE KARENA ADA METHOD EDIT YANG MENGGUNAKAN NIK SEBAGAI PARAMETER BUKAN ID
        Route::group(['prefix' => 'employees'], function () {

            route::get('/', [EmployeeController::class, 'index'])->name('karyawan.index');
            route::get('/create', [EmployeeController::class, 'create']);
            route::patch('update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
            route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
            route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

            route::patch('/update/kontrak/{id}', [EmployeeController::class, 'updateKontrak'])->name('update.kontrak');
            route::get('/server-side', [EmployeeController::class, 'serverSideEmployee']);
            route::get('/divisi/{id}', [EmployeeController::class, 'fetchDivisi'])->name('fetch/divisi');
            route::get('/mutasi', [EmployeeController::class, 'mutasi']);
            route::post('/mutasi/update', [EmployeeController::class, 'mutasiUpdate'])->name('mutasi.update');

            route::get('/weekly', [EmployeeController::class, 'weekly']);
            route::get('/monthly', [EmployeeController::class, 'monthly']);

            // Maatwebsite excel 
            route::get('/import', [EmployeeController::class, 'import']);
            route::get('/download-example', [EmployeeController::class, 'downloadExample'])->name('download.example');
            route::post('/import-employee', [EmployeeController::class, 'importEmployee'])->name('import.employee');
            route::post('/update-import-employee', [EmployeeController::class, 'updateImportEmployee'])->name('updateImport.employee');
            route::post('/destroy-import-employee', [EmployeeController::class, 'destroyImportEmployee'])->name('destroyImport.employee');
            route::get('/download-employee', [EmployeeController::class, 'employeesExport'])->name('employees.export');
            // Maatwebsite excel end 
        });
        // END EMPLOYEE ROUTE GROUP

        // COMPANY, DEPARTMENT, DIVISION ROUTES
        route::resource('perusahaan', 'App\Http\Controllers\Admin\PerusahaanController');

        route::resource('divisi', 'App\Http\Controllers\Admin\DivisiController');
        route::get('divisi/export-divisi', [DivisiController::class, 'exportDivisi'])->name('export.div');

        route::resource('departemen', 'App\Http\Controllers\DepartemenController');
        route::get('departemen/{id}/divisi', [DepartemenController::class, 'divisi'])->name('departemen.divisi');
        route::post('/tambah/divisi', [DepartemenController::class, 'updateDivisi'])->name('updateDivisi');
        // END COMPANY, DEPARTMENT, DIVISION ROUTES

        // INDUSTRIAL RELATIONS ROUTE GROUP
        Route::group(['prefix' => 'industrial-relations', 'middleware' => ['sec.hubind']], function () {
            route::get('/severance-pay', [SeverancepayController::class, 'index']);
            route::get('/severance-pay/create', [SeverancepayController::class, 'create'])->name('severance.create');
            route::post('/severance-pay/store', [SeverancepayController::class, 'store'])->name('severance.store');
            route::get('/severance-pay/print/{id}', [SeverancepayController::class, 'print'])->name('severance.print');
            route::get('/severance-pay/import', [SeverancepayController::class, 'import'])->name('severance.import');
            route::post('/severance-pay/import/store', [SeverancepayController::class, 'importStore'])->name('severance.import.store');

            route::get('/sp-report', [ReportSpController::class, 'index']);
            route::get('/sp-report/edit/{id}', [ReportSpController::class, 'edit'])->name('spreport.edit');
            route::post('/sp-report/import/store', [ReportSpController::class, 'store'])->name('spreport.import.store');
            route::post('/sp-report/import/update', [ReportSpController::class, 'update'])->name('spreport.import.update');
            route::post('/sp-report/import/destroy', [ReportSpController::class, 'destory'])->name('spreport.import.destroy');
            route::get('/sp-report/import', [ReportSpController::class, 'importView'])->name('spreport.import');
            route::get('/sp-report/serverside', [ReportSpController::class, 'serverSidePeringatan']);

            route::get('/resign', [ResignController::class, 'index']);
            route::get('/resign/show/{id}', [ResignController::class, 'show'])->name('resign.show');
            route::post('/resign/import/store', [ResignController::class, 'store'])->name('resign.import.store');
            route::post('/resign/import/update', [ResignController::class, 'update'])->name('resign.import.update');
            route::get('/resign/surat/{id}', [ResignController::class, 'surat'])->name('resign.surat');
            route::get('/resign/import', [ResignController::class, 'importView']);
            route::get('/server-side/resign', [ResignController::class, 'serverSideResign']);
        });
        // END INDUSTRIAL RELATIONS ROUTE GROUP

        // ROSTER AND WILAYAH ROUTE GROUP
        Route::group(['prefix' => 'roster'], function () {

            route::post('/store', [CutiIzinController::class, 'cutiRosterStore'])->name('cutiroster.store');
            route::post('/upload/tiket/{id}', [CutiIzinController::class, 'uploadTiketPesawat'])->name('cutiroster.upload.tiket');
            route::post('/download/tiket/{id}', [CutiIzinController::class, 'downloadTiketPesawat'])->name('cutiroster.download.tiket');
            route::get('/download/berkas/{id}', [CutiIzinController::class, 'downloadBerkas'])->name('cutiroster.download');

            route::post('/import-karyawan-roster', [KaryawanRosterController::class, 'importKaryawanRoster'])->name('import.karyawanRoster');
            route::post('/import-delete-karyawan-roster', [KaryawanRosterController::class, 'importDeleteKaryawanRoster'])->name('import.deleteKaryawanRoster');
            route::get('/aktif', [KaryawanRosterController::class, 'rosterAktif']);
            route::patch('/update/status-pengajuan/{id}', [KaryawanRosterController::class, 'updateStatusPengajuan'])->name('update.statusPengajuan');
        });

        Route::group(['prefix' => 'wilayah'], function () {
            route::get('/', [WilayahController::class, 'index'])->name('wilayah.index');
            route::get('/excel', [WilayahController::class, 'exportExcel'])->name('export-wilayah-excel');
            route::get('/pdf', [WilayahController::class, 'exportPdf'])->name('export-wilayah-pdf');
        });
        // END ROUTE GROUP BAGIAN ADMIN
    });

    route::get('/lihat-pengingat', [KaryawanRosterController::class, 'pengingatPribadi']);

    // ROUTE GROUP BAGIAN ADMIN DEPARTEMEN/DIVISI
    Route::group(['prefix' => 'admin/', 'middleware' => ['isAdminDivisi']], function () {
        route::get('/pengingat', [KaryawanRosterController::class, 'viewAdminDept']);
        route::get('/permohonan', [KaryawanRosterController::class, 'adminListPengajuan']);
        route::get('permohonan/detail/{id}', [CutiIzinController::class, 'viewAdminDeptDetailPengajuan'])->name('detail.pengajuan.roster');
        route::get('pengajuan/{id}', [KaryawanRosterController::class, 'viewAdminDeptFormCuti'])->name('admindept.formcuti');
        route::get('pengajuan/print/{id}', [KaryawanRosterController::class, 'viewAdminPrint'])->name('admindept.print');
        route::patch('/update/{id}', [CutiIzinController::class, 'adminCutiRosterUpdate'])->name('admindept.update.pengajuan');

        Route::group(['prefix' => 'lembur/'], function () {
            route::get('/', [LemburController::class, 'index']);
            route::get('/server-side-lembur', [LemburController::class, 'serverSideLembur']);
            route::get('/create', [LemburController::class, 'create']);
            route::post('/store', [LemburController::class, 'store'])->name('store.lembur');
            route::get('/show/{id}', [LemburController::class, 'show'])->name('show.lembur');
            route::patch('/update/{id}', [LemburController::class, 'update'])->name('update.lembur');
        });

        Route::group(['prefix' => 'cuti/'], function () {
            route::get('/', [CutiIzinController::class, 'viewAdminDeptCuti']);
            route::get('/tahunan', [CutiIzinController::class, 'viewAdminDeptCutiTahunan']);
            route::post('/tahunan/store', [CutiIzinController::class, 'adminDeptstoreCutiTahunan']);
            route::get('/paidleave', [CutiIzinController::class, 'viewAdminDeptPaidLeave']);
            route::post('/paidleave/store', [CutiIzinController::class, 'viewAdminStorePaidLeave']);
            route::get('unpaidleave', [CutiIzinController::class, 'viewAdminDeptUnpaidLeave']);
            route::post('/unpaidleave/store', [CutiIzinController::class, 'viewAdminStoreUnpaidLeave']);
            route::get('/update/status/{id}', [CutiIzinController::class, 'adminUpdateStatusPengajuan'])->name('adminupdate.statuspengajuan');
            route::get('/server-side', [CutiIzinController::class, 'serversideAdminCuti']);
        });
    });
    // END ROUTE GROUP BAGIAN ADMIN DEPARTEMEN/DIVISI

    // ROUTE GROUP BAGIAN SELF SERVICE / EMPLOYEE SELF SERVICE
    Route::group(['prefix' => 'ess'], function () {

        route::get('/', [CutiIzinController::class, 'index']);

        route::get('/cuti-tahunan', [CutiTahunanController::class, 'index']);
        route::post('/store/cuti-tahunan', [CutiTahunanController::class, 'store'])->name('store.cuti-tahunan');

        route::get('/cuti-roster', [CutiRosterController::class, 'index']);
        route::post('/store/cuti-roster', [CutiRosterController::class, 'store'])->name('store.cuti-roster');
        route::get('/show/cuti-roster/{id}', [CutiRosterController::class, 'show'])->name('show.cuti-roster');
        route::delete('destroy/cuti-roster/{id}', [CutiRosterController::class, 'destroy'])->name('destroy.cuti-roster');

        Route::group(['prefix' => 'status'], function () {
            route::get('/pengajuan', [StatusPengajuanController::class, 'index']);
            route::get('/roster', [StatusPengajuanController::class, 'statusRoster']);
        });

        route::get('/izin-dibayarkan', [CutiIzinController::class, 'index']);
        route::post('/store-izin-dibayarkan', [CutiIzinController::class, 'store'])->name('store.izin-dibayarkan');

        route::get('izin-tidak-dibayarkan', [IzinTidakBerbayarController::class, 'index']);
        route::post('/store-izin-tidak-dibayarkan', [IzinTidakBerbayarController::class, 'store'])->name('store.izin-tidak-dibayarkan');

        route::get('/slip-gaji', [SlipGajiController::class, 'index']);
        route::get('/slip-gaji/{id}', [SlipGajiController::class, 'show'])->name('show.slip-gaji');
        route::get('/print/slip-gaji/{id}', [SlipGajiController::class, 'cetak_pdf'])->name('cetak.slip-gaji');

        route::get('/lembur', [SelfServiceLemburController::class, 'index']);
        route::get('/show/{id}', [SelfServiceLemburController::class, 'show'])->name('show.lembur');
        route::patch('/update/{id}', [SelfServiceLemburController::class, 'update'])->name('update.lembur');

        Route::group(['prefix' => 'tiket'], function () {
            route::get('/', [TiketController::class, 'index']);
            route::get('/download/{id}', [TiketController::class, 'downloadTiketPesawat'])->name('karyawan.download.tiket');
        });

        Route::group(['prefix' => 'kehadiran'], function () {
            route::get('/', [AbsensiController::class, 'index']);
            route::post('/store', [AbsensiController::class, 'store'])->name('store.absensi');
            route::patch('/update/istirhat/{id}', [AbsensiController::class, 'updateJamIstirahat'])->name('update.absensi.istirahat');
            route::patch('/update/kembali-istirahat{id}', [AbsensiController::class, 'updateJamKembaliIstirahat'])->name('update.absensi.kembali.istirahat');
            route::patch('/update/{id}', [AbsensiController::class, 'update'])->name('update.absensi');
        });
    });
    // END ROUTE GROUP BAGIAN SELF SERVICE / EMPLOYEE SELF SERVICE

    Route::group(['prefix' => 'account'], function () {
        route::get('/profile', [AccountController::class, 'profile']);
        route::get('/pengajuan', [AccountController::class, 'pengajuan']);
        route::patch('/update/{id}', [AccountController::class, 'update'])->name('account.update');
        route::get('/contract', [AccountController::class, 'contract'])->name('contract');
        route::patch('/update/akun/{id}', [AccountController::class, 'updateAkun'])->name('update.akun');
    });

    // API ROUTE GROUP
    Route::group(['prefix' => 'api/hrcorner/'], function () {
        route::get('search-employee', [ApiController::class, 'searchEmployee']);
        route::get('search-employee-div', [ApiController::class, 'searchEmployeeByDiv']);
        route::get('detail-employee/{id}', [ApiController::class, 'getEmployeeById']);
        route::get('airports', [ApiController::class, 'getAirport']);
        route::get('divisi/{id}', [ApiController::class, 'getDivisi']);
        route::get('employees', [ApiController::class, 'getEmployeeWithEntryDate']);
        route::get('employees/monthly', [ApiController::class, 'getEmployeeMonthly']);
        route::post('data-kabupaten', [ApiController::class, 'getKabupaten']);
        route::post('data-kecamatan', [ApiController::class, 'getKecamatan']);
    });
    // END API ROUTE GROUP
});
