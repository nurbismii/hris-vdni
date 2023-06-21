<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeteranganAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterangan_absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nik_karyawan');
            $table->string('periode')->nullable();
            $table->unsignedBigInteger('periode_bulan_id');
            $table->date('tanggal_mulai_izin');
            $table->date('tanggal_selesai_izin');
            $table->string('total_izin');
            $table->text('keterangan_izin');
            $table->text('status_izin');
            $table->timestamps();

            $table->foreign('periode_bulan_id')->references('id')->on('periode_bulans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keterangan_absensis');
    }
}
