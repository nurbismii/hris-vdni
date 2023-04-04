<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->string('no_pkwt', 128)->primary();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('nik', 16)->default('0');
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_ktp', 20);
            $table->string('jabatan');
            $table->string('lama_kontrak')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->date('tanggal_mulai_kontrak');
            $table->string('lama_kontrak_terakhir')->nullable();
            $table->string('gaji')->nullable();
            $table->string('uang_makan')->nullable();
            $table->string('hm')->nullable();
            $table->string('tunjangan_jabatan');
            $table->string('keterangan_kontrak');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
