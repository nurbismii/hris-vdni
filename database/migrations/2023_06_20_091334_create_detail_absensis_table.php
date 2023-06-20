<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_bulan_id');
            $table->unsignedBigInteger('nik_karyawan');
            $table->string('total_alpa', 4);
            $table->string('paid_leave', 4);
            $table->string('unpaid_leave', 4);
            $table->string('total_sakit', 4);
            $table->string('total_off', 4);
            $table->string('total_cuti', 4);
            $table->string('total_libur', 4);
            $table->string('total_workdays', 4);
            $table->string('total_absen', 4);
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
        Schema::dropIfExists('detail_absensis');
    }
}
