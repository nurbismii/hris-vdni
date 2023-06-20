<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodeBulansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periode_bulans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_tahun_id');
            $table->string('nama_bulan', 32);
            $table->timestamps();

            $table->foreign('periode_tahun_id')->references('id')->on('periode_tahuns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periode_bulans');
    }
}
