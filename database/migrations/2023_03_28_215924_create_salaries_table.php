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
            $table->unsignedBigInteger('created_by');
            $table->date('durasi_sp')->nullable();
            $table->string('jumlah_hari_kerja', 4)->nullable();
            $table->string('jumlah_hour_machine', 8)->nullable();
            $table->string('gaji_pokok', 64)->nullable();
            $table->string('tunjangan_umum', 64)->nullable();
            $table->string('tunjangan_pengawas', 64)->nullable();
            $table->string('tunjangan_transport', 64)->nullable();
            $table->string('tunjangan_mk', 64)->nullable();
            $table->string('tunjangan_koefisien', 64)->nullable();
            $table->string('ot', 128)->nullable();
            $table->string('hm', 64)->nullable();
            $table->string('rapel', 64)->nullable();
            $table->string('insentif', 128)->nullable();
            $table->string('tunjangan_lap', 128)->nullable();
            $table->string('jht', 128)->nullable();
            $table->string('jp', 128)->nullable();
            $table->string('bpjs_kesehatan', 128)->nullable();
            $table->string('unpaid_leave', 128)->nullable();
            $table->string('deduction', 128)->nullable();
            $table->string('total_diterima', 128)->nullable();
            $table->string('bank', 128)->nullable();
            $table->string('account_number', 128)->nullable();
            $table->string('periode', 128)->nullable();
            $table->string('departemen', 128)->nullable();
            $table->string('divisi', 128)->nullable();
            $table->string('posisi', 128)->nullable();
            $table->string('status_gaji', 128)->nullable();
            $table->string('thr', 128)->nullable();
            $table->string('bonus', 128)->nullable();
            $table->string('deduction_pph21', 128)->nullable();
            $table->text('note')->nullable();
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
