<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CutiIzinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DetailAbsensiController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KaryawanRosterController;
use App\Http\Controllers\KeteranganAbsensiController;
use App\Http\Controllers\LokasiAbsenController;
use App\Http\Controllers\PasalController;
use App\Http\Controllers\PeriodeRosterController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\SeverancepayController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WaktuAbsenController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ReportSpController;
use App\Http\Controllers\ResignController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PerusahaanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/konfirmasi-email/{nik_karyawan}', [RegisterController::class, 'konfirmasiEmail']);

Auth::routes();

Route::post('/new-register', [RegisterController::class, 'register'])->name('register.employee')->middleware('employee.registered');
Route::get('/', [DashboardController::class, 'index'])->middleware('email.verify');
Route::get('dashboard/fetch-kabupaten/{id}', [DashboardController::class, 'fetchKabupaten']);
Route::get('dashboard/fetch-kecamatan/{id}', [DashboardController::class, 'fetchKecamatan']);
Route::get('dashboard/fetch-kelurahan/{id}', [DashboardController::class, 'fetchKelurahan']);

Route::group(['middleware' => ['auth', 'audit.trails', 'email.verify']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/store/absen', [WaktuAbsenController::class, 'storeAbsen'])->name('store.absen');
    route::get('/lihat-pengingat', [KaryawanRosterController::class, 'pengingatPribadi']);

    Route::group(['prefix' => 'admin/roster/'], function () {
        route::get('', [KaryawanRosterController::class, 'viewAdminDept']);
        route::get('pengajuan/{id}', [KaryawanRosterController::class, 'viewAdminDeptFormCuti'])->name('admindept.formcuti');
        route::get('pengajuan/print/{id}', [KaryawanRosterController::class, 'viewAdminPrint'])->name('admindept.print');
        route::post('/pengajuan/store', [KaryawanRosterController::class, 'adminDeptStore'])->name('admindept.cuti.store');
        route::get('/permohonan', [KaryawanRosterController::class, 'adminDeptListCetak'])->name('admindept.listcetak');
    });

    Route::group(['prefix' => 'admin/cuti/'], function () {
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

    Route::group(['prefix' => 'absen'], function () {
        route::get('/', [AbsensiController::class, 'index']);
        route::post('/store', [AbsensiController::class, 'store'])->name('store.absensi');
        route::patch('/update/{id}', [AbsensiController::class, 'update'])->name('update.absensi');

        route::group(['middleware' => 'isAdmin'], function () {
            // Detail Absensi Controller
            route::get('/detail', [DetailAbsensiController::class, 'getDetailAbsensi']);
            route::get('/detail/all-in', [DetailAbsensiController::class, 'getDetailAllIn']);
            route::post('/import-data-absen', [DetailAbsensiController::class, 'importAbsensi'])->name('import.absensi');
            route::post('/import-data-absen/destroy', [DetailAbsensiController::class, 'importDeleteAbsensi'])->name('import.destroy.absensi');
            route::get('/dropdown-bulan/{id}', [DetailAbsensiController::class, 'dropwdownBulan']);
            route::get('/server-side', [DetailAbsensiController::class, 'serverSideAllin']);
            route::get('/all-in/detail/{nik}', [DetailAbsensiController::class, 'show'])->name('all-in/detail');
            // End Detail Absensi Controller

            // Keterangan Absen
            route::post('/import-keterangan', [KeteranganAbsensiController::class, 'ImportKeteranganAbsen'])->name('import.keterangan');
            route::delete('/destroy/ket/{id}', [KeteranganAbsensiController::class, 'destroy'])->name('destroy.ket');
            // End Keterangan Absen
        });
    });

    Route::group(['prefix' => 'account'], function () {
        route::get('/profile', [AccountController::class, 'profile']);
        route::get('/information', [AccountController::class, 'billing']);
        route::get('/pengajuan', [AccountController::class, 'pengajuan']);
        route::get('/invoice/{id}', [AccountController::class, 'show'])->name('invoice');
        route::patch('/update/{id}', [AccountController::class, 'update'])->name('account.update');
        route::get('/contract', [AccountController::class, 'contract'])->name('contract');
        route::get('/slip-gaji/{id}', [AccountController::class, 'cetak_pdf'])->name('slipgaji');
    });

    Route::group(['prefix' => 'tiket'], function () {
        route::get('/', [AccountController::class, 'tiket']);
        route::get('/download/{id}', [CutiIzinController::class, 'downloadTiketPesawat'])->name('karyawan.download.tiket');
    });

    Route::group(['middleware' => 'isAdmin'], function () {

        Route::get('/audit-trails', [DashboardController::class, 'auditTrails']);
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

            route::get('/pasal', [PasalController::class, 'index']);
            route::post('/store/pasal', [PasalController::class, 'store'])->name('store.pasal');
            route::patch('/update/pasal/{id}', [PasalController::class, 'update'])->name('update.pasal');
            route::delete('/destroy/pasal/{id}', [PasalController::class, 'destroy'])->name('destroy.pasal');
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
            route::get('/', [EmployeeController::class, 'index'])->name('karyawan.index');
            route::get('/karyawan/data-lanjut', [EmployeeController::class, 'dataLanjut'])->name('karyawan.data-lanjut');
            route::get('/create', [EmployeeController::class, 'create']);
            route::patch('update/{id}', [EmployeeController::class, 'update'])->name('update.employee');
            route::patch('/update/kontrak/{id}', [EmployeeController::class, 'updateKontrak'])->name('update.kontrak');
            route::get('/edit/{nik}', [EmployeeController::class, 'edit'])->name('employee.edit');
            route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy.employee');
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
            // Maatwebsite excel end 
        });

        // Route::group(['prefix' => 'salary'], function () {
        //     route::get('/', [SalaryController::class, 'index']);
        //     route::get('/history', [SalaryController::class, 'history']);
        //     route::get('/components/{id}', [SalaryController::class, 'downloadSalaryComponent'])->name('components.donwload');
        //     route::get('/payslip', [SalaryController::class, 'payslip'])->name('salary.payslip');
        //     route::get('/payslip/print/{id}', [SalaryController::class, 'printPayslip'])->name('payslip.print');
        //     route::post('/import-salarys', [SalaryController::class, 'importSalary'])->name('import.salary');
        //     route::get('/export-template', [SalaryController::class, 'exportSalary'])->name('export.salary');
        //     route::get('/show/{id}', [SalaryController::class, 'show'])->name('salary.show');
        //     // route::get('/employee', [SalaryController::class, 'gajikaryawan'])->name('salary.employee');
        //     route::get('/create/salary', [SalaryController::class, 'createSalary'])->name('create.salary');
        //     route::post('/store/gaji-karyawan', [SalaryController::class, 'storeGajiKaryawan'])->name('store/gaji-karyawan');
        //     route::get('/server-side', [SalaryController::class, 'serverSideSalary']);
        //     route::post('/generate/payslip/{nik}', [SalaryController::class, 'generateSlip'])->name('generate.slip');
        // });

        Route::group(['prefix' => 'contract'], function () {
            route::get('/', [ContractController::class, 'index']);
            route::get('/server-side', [ContractController::class, 'serverSide']);
            route::post('/import-pkwt', [ContractController::class, 'importContract']);
            route::post('/destroy-import-pkwt', [ContractController::class, 'destroyImportContract'])->name('destroyImport.contract');
            route::get('/show/{nik}', [ContractController::class, 'show'])->name('contract.show');
        });

        Route::group(['prefix' => 'industrial-relations'], function () {
            route::get('/severance-pay', [SeverancepayController::class, 'index']);
            route::get('/severance-pay/create', [SeverancepayController::class, 'create'])->name('severance.create');
            route::post('/severance-pay/store', [SeverancepayController::class, 'store'])->name('severance.store');
            route::get('/severance-pay/print/{id}', [SeverancepayController::class, 'print'])->name('severance.print');
            route::get('/severance-pay/import', [SeverancepayController::class, 'import'])->name('severance.import');
            route::post('/severance-pay/import/store', [SeverancepayController::class, 'importStore'])->name('severance.import.store');

            route::get('/sp-report', [ReportSpController::class, 'index']);
            route::get('/sp-report/edit/{id}', [ReportSpController::class, 'edit'])->name('spreport.edit');
            route::get('/sp-report/import', [ReportSpController::class, 'importView'])->name('spreport.import');
            route::post('/sp-report/import/store', [ReportSpController::class, 'importStore'])->name('spreport.import.store');
            route::post('/sp-report/import/update', [ReportSpController::class, 'importUpdate'])->name('spreport.import.update');
            route::post('/sp-report/import/destroy', [ReportSpController::class, 'importDestroy'])->name('spreport.import.destroy');

            route::get('/server-side/resign', [ResignController::class, 'serverSideResign']);
            route::get('/resign/edit/{id}', [ResignController::class, 'edit'])->name('resign.edit');

            route::get('/resign/surat/{id}', [ResignController::class, 'surat'])->name('resign.surat');

            route::get('/resign', [ResignController::class, 'index']);
            route::get('/resign/import', [ResignController::class, 'importView']);
            route::post('/resign/import/store', [ResignController::class, 'importStore'])->name('resign.import.store');
            route::post('/resign/import/update', [ResignController::class, 'importUpdate'])->name('resign.import.update');
        });

        Route::group(['prefix' => 'perusahaan'], function () {
            route::get('/', [PerusahaanController::class, 'index']);
            route::post('/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
            route::get('/{id}/show', [PerusahaanController::class, 'show'])->name('perusahaan.show');
            route::patch('/{id}/update', [PerusahaanController::class, 'update'])->name('perusahaan.update');
            route::delete('/{id}/destroy', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');
        });

        Route::group(['prefix' => 'departemen'], function () {
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

        Route::group(['prefix' => 'roster'], function () {
            route::get('/kalender', [KaryawanRosterController::class, 'index']);
            route::post('/import-karyawan-roster', [KaryawanRosterController::class, 'importKaryawanRoster'])->name('import.karyawanRoster');
            route::post('/import-delete-karyawan-roster', [KaryawanRosterController::class, 'importDeleteKaryawanRoster'])->name('import.deleteKaryawanRoster');
            route::get('/daftar-pengingat', [KaryawanRosterController::class, 'reminder']);
            route::get('/aktif', [KaryawanRosterController::class, 'rosterAktif']);
            route::patch('/update/status-pengajuan/{id}', [KaryawanRosterController::class, 'updateStatusPengajuan'])->name('update.statusPengajuan');
        });

        Route::group(['prefix' => 'pengajuan-karyawan'], function () {
            route::get('/', [CutiIzinController::class, 'index']);
            route::get('/server-side', [CutiIzinController::class, 'serverSidePengajuan']);
            route::get('/import', [CutiIzinController::class, 'importViewPengajuan'])->name('import.pengajuan');
            route::post('/import/store', [CutiIzinController::class, 'importStorePengajuan'])->name('import.store.pengajuan');
            route::get('/cuti', [CutiIzinController::class, 'cutiIzin']);
            route::post('/store-cuti', [CutiIzinController::class, 'storeCutiIzin']);
            route::get('/izin-dibayarkan', [CutiIzinController::class, 'izinDibayar']);
            route::post('/store-izin-dibayarkan', [CutiIzinController::class, 'storeIzinDibayarkan']);
            route::get('izin-tidak-dibayarkan', [CutiIzinController::class, 'izinTidakDibayarkan']);
            route::post('/store-izin-tidak-dibayarkan', [CutiIzinController::class, 'storeIzinTidakDibayarkan']);
            route::get('/update/status-diterima/{id}', [CutiIzinController::class, 'updateStatusPengajuanDiterima'])->name('update.statuspengajuan.diterima');
            route::get('/update/status-ditolak/{id}', [CutiIzinController::class, 'updateStatusPengajuanDitolak'])->name('update.statuspengajuan.ditolak');
            route::get('/destroy/{id}', [CutiIzinController::class, 'pengajuanKaryawanDestroy'])->name('pengajuan-karyawan/destroy');
        });

        Route::group(['prefix' => 'roster'], function () {
            route::get('/', [CutiIzinController::class, 'cutiRoster']);
            route::get('/server-side', [CutiIzinController::class, 'serverSideCutiRoster']);
            route::get('/create', [CutiIzinController::class, 'cutiRosterCreate']);
            route::post('/store', [CutiIzinController::class, 'cutiRosterStore'])->name('cutiroster.store');
            route::post('/update/{id}', [CutiIzinController::class, 'cutiRosterUpdate'])->name('cutiroster.update');
            route::get('/detail/{id}', [CutiIzinController::class, 'cutiRosterShow'])->name('cutiroster.show');
            route::post('/upload/tiket/{id}', [CutiIzinController::class, 'uploadTiketPesawat'])->name('cutiroster.upload.tiket');
            route::post('/download/tiket/{id}', [CutiIzinController::class, 'downloadTiketPesawat'])->name('cutiroster.download.tiket');
            route::get('/download/berkas/{id}', [CutiIzinController::class, 'downloadBerkas'])->name('cutiroster.download');
        });

        Route::group(['prefix' => 'periode'], function () {
            route::get('/', [PeriodeRosterController::class, 'index']);
            route::post('/store', [PeriodeRosterController::class, 'store'])->name('store.periodeRoster');
            route::patch('/update/{id}', [PeriodeRosterController::class, 'update'])->name('update.periodeRoster');
            route::delete('/delete/{id}', [PeriodeRosterController::class, 'destroy'])->name('destroy.periodeRoster');
        });

        Route::group(['prefix' => 'wilayah'], function () {
            route::get('/', [WilayahController::class, 'index']);
            route::get('/{provinsi}/{kabupaten}/{kecamatan}', [WilayahController::class, 'exportExcel'])->name('export-wilayah');
        });
    });
    Route::group(['prefix' => 'api/hrcorner/'], function () {
        route::get('search-employee', [ApiController::class, 'searchEmployee']);
        route::get('detail-employee/{id}', [ApiController::class, 'getEmployeeById']);
        route::get('airports', [ApiController::class, 'getAirport']);
        route::get('divisi/{id}', [ApiController::class, 'getDivisi']);
        route::get('employees', [ApiController::class, 'getEmployeeWithEntryDate']);
        route::get('employees/monthly', [ApiController::class, 'getEmployeeMonthly']);
    });
});
