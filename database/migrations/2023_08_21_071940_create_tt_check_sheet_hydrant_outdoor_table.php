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
            $table->text('catatan_pintu')->nullable();
            $table->string('photo_pintu');
            $table->string('nozzle');
            $table->text('catatan_nozzle')->nullable();
            $table->string('photo_nozzle');
            $table->string('selang');
            $table->text('catatan_selang')->nullable();
            $table->string('photo_selang');
            $table->string('tuas');
            $table->text('catatan_tuas')->nullable();
            $table->string('photo_tuas');
            $table->string('pilar');
            $table->text('catatan_pilar')->nullable();
            $table->string('photo_pilar');
            $table->string('penutup');
            $table->text('catatan_penutup')->nullable();
            $table->string('photo_penutup');
            $table->string('rantai');
            $table->text('catatan_rantai')->nullable();
            $table->string('photo_rantai');
            $table->string('kupla');
            $table->text('catatan_kupla')->nullable();
            $table->string('photo_kupla');
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
