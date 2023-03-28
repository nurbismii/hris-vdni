<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->unsignedBigInteger('employee_id');
            $table->date('durasi_sp');
            $table->string('jumlah_hari_kerja', 4);
            $table->string('jumlah_hour_machine', 8);
            $table->string('gaji_pokok', 64);
            $table->string('tunjangan_umum', 64);
            $table->string('tunjangan_pengawas', 64);
            $table->string('tunjangan_transport', 64);
            $table->string('tunjangan_mk', 64);
            $table->string('tunjangan_koefisien', 64);
            $table->string('ot', 128);
            $table->string('hm', 64);
            $table->string('rapel', 64);
            $table->string('insentif', 128);
            $table->string('tunjangan_lap', 128);
            $table->string('jht', 128);
            $table->string('jp', 128);
            $table->string('bpjs_kesahatan', 128);
            $table->string('unpaid_leave', 128);
            $table->string('deduction', 128);
            $table->string('total_diterima', 128);
            $table->string('bank', 128);
            $table->string('account_number', 128);
            $table->string('periode', 128);
            $table->string('departemen', 128);
            $table->string('divisi', 128);
            $table->string('posisi', 128);
            $table->string('status_gaji', 128);
            $table->string('thr', 128);
            $table->string('bonus', 128);
            $table->string('deduction_pph21', 128);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
