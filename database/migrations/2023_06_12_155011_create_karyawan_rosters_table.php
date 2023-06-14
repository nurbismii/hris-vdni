<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanRostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan_rosters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nik_karyawan');
            $table->unsignedBigInteger('periode_id');
            $table->date('minggu_pertama')->nullable();
            $table->date('minggu_kedua')->nullable();
            $table->date('minggu_ketiga')->nullable();
            $table->date('minggu_keempat')->nullable();
            $table->date('minggu_kelima')->nullable();
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periode_rosters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan_rosters');
    }
}
