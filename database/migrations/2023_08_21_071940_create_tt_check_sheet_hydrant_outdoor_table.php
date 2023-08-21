<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_check_sheet_hydrant_outdoor', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('hydrant_number');
            $table->string('pintu');
            $table->string('nozzle');
            $table->string('selang');
            $table->string('tuas');
            $table->string('pilar');
            $table->string('penutup');
            $table->string('rantai');
            $table->string('kupla');
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
        Schema::dropIfExists('tt_check_sheet_hydrant_outdoor');
    }
};
