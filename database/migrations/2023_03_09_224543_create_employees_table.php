<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('nik')->primary();
            $table->string('no_sk_pkwtt')->nullable();
            $table->string('nama_karyawan');
            $table->string('nama_ibu_kandung');
            $table->string('agama');
            $table->string('no_ktp', 16);
            $table->string('no_kk', 16)->nullable();
            $table->enum('jenis_kelamin', array('L', 'P'));
            $table->enum('status_perkawinan', array('Kawin', 'Belum Kawin', 'Cerai'));
            $table->string('status_karyawan');
            $table->date('tgl_resign')->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->date('tgl_lahir');
            $table->string('area_kerja');
            $table->string('golongan_darah', 8)->nullable();
            $table->string('foto_karyawan')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('npwp', 64)->nullable();
            $table->string('bpjs_kesehatan', 64)->nullable();
            $table->string('bpjs_tk', 64)->nullable();
            $table->enum('vaksin', array('0', '1', '2', '3', '4'))->default('0');
            $table->string('jam_kerja')->nullable();
            $table->string('status_resign', 16)->nullable();
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
        Schema::dropIfExists('employees');
    }
}
