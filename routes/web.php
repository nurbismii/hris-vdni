<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import controllers
use App\Http\Controllers\{
    AbsensiController,
    AccountController,
    ApiController,
    Auth\ForgotPasswordController,
    Auth\RegisterController,
    Auth\ResetPasswordController,
    CutiIzinController,
    DashboardController,
    DepartemenController,
    DivisiController,
    EmployeeController,
    KaryawanRosterController,
    LemburController,
    LokasiAbsenController,
    PasalController,
    PeriodeRosterController,
    PerusahaanController,
    ReportSpController,
    ResignController,
    Role\RoleController,
    SalaryController,
    SeverancepayController,
    User\UserController,
    WaktuAbsenController,
    WilayahController
};

Route::get('/konfirmasi/{id}', [RegisterController::class, 'konfirmasiEmail'])->name('email.confirm');
Route::get('/lupa-kata-sandi', [ForgotPasswordController::class, 'index']);
Route::post('/reset-kata-sandi', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');
Route::get('/set-kata-sandi/{id}', [ResetPasswordController::class, 'setPassword'])->name('set.password');
Route::patch('/update/kata-sandi/{id}', [ResetPasswordController::class, 'updatePassword'])->name('update.password');

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

    Route::group(['prefix' => 'ess'], function () {
        route::get('/', [CutiIzinController::class, 'index']);
        route::get('/server-side', [CutiIzinController::class, 'serverSidePengajuan']);
        route::get('/cuti/tahunan', [CutiIzinController::class, 'cutiIzin']);
        route::get('/cuti/roster', [CutiIzinController::class, 'cutiRosterCreate']);
        route::post('/store-cuti', [CutiIzinController::class, 'storeCutiIzin']);
        route::get('/izin-dibayarkan', [CutiIzinController::class, 'izinDibayar']);
        route::post('/store-izin-dibayarkan', [CutiIzinController::class, 'storeIzinDibayarkan']);
        route::get('izin-tidak-dibayarkan', [CutiIzinController::class, 'izinTidakDibayarkan']);
        route::post('/store-izin-tidak-dibayarkan', [CutiIzinController::class, 'storeIzinTidakDibayarkan']);
        route::post('/pengajuan/store', [KaryawanRosterController::class, 'pengajuanCutiRoster'])->name('store.pengajuan.roster');
        route::get('/detail/{id}', [KaryawanRosterController::class, 'pengajuanCutiRosterDetail'])->name('show.pengajuan.roster');
        route::delete('/delete/{id}', [KaryawanRosterController::class, 'pengajuanCutiRosterHapus'])->name('destroy.pengajuan.roster');
        route::get('/lembur', [LemburController::class, 'karyawanLembur']);
        route::get('/show/{id}', [LemburController::class, 'karyawanLemburShow'])->name('karyawan.lembur.show');
        route::patch('/update/{id}', [LemburController::class, 'karyawanLemburUpdate'])->name('karyawan.lembur.update');

        Route::group(['prefix' => 'status'], function () {
            route::get('/permohonan', [AccountController::class, 'statusPermohonan']);
            route::get('/pengajuan', [AccountController::class, 'pengajuan']);
        });
    });

    Route::group(['prefix' => 'absen'], function () {
        route::get('/', [AbsensiController::class, 'index']);
        route::post('/store', [AbsensiController::class, 'store'])->name('store.absensi');
        route::patch('/update/istirhat/{id}', [AbsensiController::class, 'updateJamIstirahat'])->name('update.absensi.istirahat');
        route::patch('/update/kembali-istirahat{id}', [AbsensiController::class, 'updateJamKembaliIstirahat'])->name('update.absensi.kembali.istirahat');
        route::patch('/update/{id}', [AbsensiController::class, 'update'])->name('update.absensi');
    });

    Route::group(['prefix' => 'account'], function () {
        route::get('/profile', [AccountController::class, 'profile']);
        route::get('/slip-gaji', [AccountController::class, 'slipgaji']);
        route::get('/pengajuan', [AccountController::class, 'pengajuan']);
        route::get('/invoice/{id}', [AccountController::class, 'show'])->name('invoice');
        route::patch('/update/{id}', [AccountController::class, 'update'])->name('account.update');
        route::get('/contract', [AccountController::class, 'contract'])->name('contract');
        route::get('/slip-gaji/{id}', [AccountController::class, 'cetak_pdf'])->name('slipgaji');
        route::patch('/update/akun/{id}', [AccountController::class, 'updateAkun'])->name('update.akun');
    });

    Route::group(['prefix' => 'tiket'], function () {
        route::get('/', [AccountController::class, 'tiket']);
        route::get('/download/{id}', [CutiIzinController::class, 'downloadTiketPesawat'])->name('karyawan.download.tiket');
    });

    Route::group(['prefix' => 'pengajuan-karyawan'], function () {
        route::get('/server-side', [CutiIzinController::class, 'serverSidePengajuan']);
        route::post('/import/store', [CutiIzinController::class, 'importStorePengajuan'])->name('import.store.pengajuan');

        route::post('/store-cuti', [CutiIzinController::class, 'storeCutiIzin']);
        route::get('/izin-dibayarkan', [CutiIzinController::class, 'izinDibayar']);
        route::post('/store-izin-dibayarkan', [CutiIzinController::class, 'storeIzinDibayarkan']);
        route::get('izin-tidak-dibayarkan', [CutiIzinController::class, 'izinTidakDibayarkan']);
        route::post('/store-izin-tidak-dibayarkan', [CutiIzinController::class, 'storeIzinTidakDibayarkan']);
        route::get('/update/status-diterima/{id}', [CutiIzinController::class, 'updateStatusPengajuanDiterima'])->name('update.statuspengajuan.diterima');
        route::get('/update/status-ditolak/{id}', [CutiIzinController::class, 'updateStatusPengajuanDitolak'])->name('update.statuspengajuan.ditolak');
        route::get('/destroy/{id}', [CutiIzinController::class, 'pengajuanKaryawanDestroy'])->name('pengajuan-karyawan/destroy');
    });

    Route::group(['middleware' => 'isAdmin'], function () {

        Route::get('/audit-trails', [DashboardController::class, 'auditTrails']);

        Route::group(['prefix' => 'kompensasi-dan-keuntungan', 'middleware' => ['sec.comben']], function () {
            route::get('/cuti-izin', [CutiIzinController::class, 'index']);
            route::get('/cuti-roster', [CutiIzinController::class, 'cutiRoster']);
            route::get('/cuti-roster/detail/{id}', [CutiIzinController::class, 'cutiRosterShow'])->name('cutiroster.show');
            route::post('/cuti-roster/update/{id}', [CutiIzinController::class, 'cutiRosterUpdate'])->name('cutiroster.update');
            route::get('cuti-izin/import', [CutiIzinController::class, 'importViewPengajuan'])->name('import.pengajuan');
            route::get('/pengingat', [KaryawanRosterController::class, 'reminder']);
            route::get('/kalender', [KaryawanRosterController::class, 'index']);
            route::get('/lembur', [LemburController::class, 'lembur']);
            route::get('/lembur/list', [LemburController::class, 'serverSideLemburAll']);
            route::get('/lembur/show/{id}', [LemburController::class, 'lemburShow'])->name('lembur.show.hr');
        });

        Route::group(['prefix' => 'salary', 'middleware' => ['sec.comben']], function () {
            route::get('/', [SalaryController::class, 'index']);
            route::get('/payslip/print/{id}', [SalaryController::class, 'printPayslip'])->name('payslip.print');
            route::get('/show/{id}', [SalaryController::class, 'show'])->name('salary.show');
            route::get('/employee', [SalaryController::class, 'gajikaryawan'])->name('salary.employee');
            route::get('/server-side', [SalaryController::class, 'serverSideSalary']);
        });

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
            route::get('/download-employee', [EmployeeController::class, 'employeesExport'])->name('employees.export');
            // Maatwebsite excel end 
        });

        Route::group(['prefix' => 'industrial-relations', 'middleware' => ['sec.hubind']], function () {
            route::get('/severance-pay', [SeverancepayController::class, 'index']);
            route::get('/severance-pay/create', [SeverancepayController::class, 'create'])->name('severance.create');
            route::post('/severance-pay/store', [SeverancepayController::class, 'store'])->name('severance.store');
            route::get('/severance-pay/print/{id}', [SeverancepayController::class, 'print'])->name('severance.print');
            route::get('/severance-pay/import', [SeverancepayController::class, 'import'])->name('severance.import');
            route::post('/severance-pay/import/store', [SeverancepayController::class, 'importStore'])->name('severance.import.store');

            route::get('/sp-report', [ReportSpController::class, 'index']);
            route::get('/sp-report/serverside', [ReportSpController::class, 'serverSidePeringatan']);
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
            route::post('/tambah/divisi', [DepartemenController::class, 'updateDivisi'])->name('updateDivisi');
        });

        Route::group(['prefix' => 'divisi'], function () {
            route::post('/store', [DivisiController::class, 'store'])->name('store.divisi');
            route::delete('/destroy/{id}', [DivisiController::class, 'destroy'])->name('destroy.divisi');
            route::patch('/update/{id}', [DivisiController::class, 'update'])->name('update.divisi');
            route::get('/export-divisi', [DivisiController::class, 'exportDivisi'])->name('export.div');
        });

        Route::group(['prefix' => 'roster'], function () {
            route::get('/server-side', [CutiIzinController::class, 'serverSideCutiRoster']);
            route::post('/store', [CutiIzinController::class, 'cutiRosterStore'])->name('cutiroster.store');
            route::post('/upload/tiket/{id}', [CutiIzinController::class, 'uploadTiketPesawat'])->name('cutiroster.upload.tiket');
            route::post('/download/tiket/{id}', [CutiIzinController::class, 'downloadTiketPesawat'])->name('cutiroster.download.tiket');
            route::get('/download/berkas/{id}', [CutiIzinController::class, 'downloadBerkas'])->name('cutiroster.download');

            route::post('/import-karyawan-roster', [KaryawanRosterController::class, 'importKaryawanRoster'])->name('import.karyawanRoster');
            route::post('/import-delete-karyawan-roster', [KaryawanRosterController::class, 'importDeleteKaryawanRoster'])->name('import.deleteKaryawanRoster');
            route::get('/aktif', [KaryawanRosterController::class, 'rosterAktif']);
            route::patch('/update/status-pengajuan/{id}', [KaryawanRosterController::class, 'updateStatusPengajuan'])->name('update.statusPengajuan');
        });

        Route::group(['prefix' => 'periode'], function () {
            route::get('/', [PeriodeRosterController::class, 'index']);
            route::post('/store', [PeriodeRosterController::class, 'store'])->name('store.periodeRoster');
            route::patch('/update/{id}', [PeriodeRosterController::class, 'update'])->name('update.periodeRoster');
            route::delete('/delete/{id}', [PeriodeRosterController::class, 'destroy'])->name('destroy.periodeRoster');
        });

        Route::group(['prefix' => 'wilayah'], function () {
            route::get('/', [WilayahController::class, 'index']);
            route::get('/excel/{area}/{provinsi}/{kabupaten}/{kecamatan}', [WilayahController::class, 'exportExcel'])->name('export-wilayah-excel');
            route::get('/pdf/{area}/{provinsi}/{kabupaten}/{kecamatan}', [WilayahController::class, 'exportPdf'])->name('export-wilayah-pdf');
        });
    });

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
});
