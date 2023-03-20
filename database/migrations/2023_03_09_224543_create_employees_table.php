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
            $table->id();
            $table->string('nik', 32);
            $table->string('no_ktp', 16);
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('company_name');
            $table->string('npwp', 64);
            $table->string('bpjs_ket', 64);
            $table->string('bpjs_tk', 64);
            $table->enum('vaccine', array('0', '1', '2', '3'))->default('0');
            $table->date('entry_date')->nullable();
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
