<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianKontraksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_kontraks', function (Blueprint $table) {
            $table->id();
            $table->string('no_pkwt');
            $table->string('jenis_kelamin');
            $table->string('nik', 32);
            $table->string('nama');
            $table->string('no_ktp', 20);
            $table->string('departemen');
            $table->string('jabatan');
            $table->int('lama_kontrak')->nullable();
            $table->string('status_perkawinan');
            $table->date('tanggal_mulai_kontrak');
            $table->date('tanggal_akhir_kontrak')->nullable();
            $table->string('gaji')->nullable();
            $table->string('uang_makan')->nullable();
            $table->string('status_print')->nullable();
            $table->date('waktu_ttd')->nullable();
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
        Schema::dropIfExists('penilaian_kontraks');
    }
}
