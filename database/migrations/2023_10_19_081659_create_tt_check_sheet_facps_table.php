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
        Schema::create('tt_check_sheet_facps', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('zona_number');
            $table->string('ok_smoke_detector')->nullable()->default(0);
            $table->integer('ng_smoke_detector')->nullable()->default(0);
            $table->text('catatan_smoke_detector')->nullable();
            $table->string('photo_smoke_detector')->nullable();
            $table->string('ok_heat_detector')->nullable()->default(0);
            $table->string('ng_heat_detector')->nullable()->default(0);
            $table->text('catatan_heat_detector')->nullable();
            $table->string('photo_heat_detector')->nullable();
            $table->string('ok_beam_detector')->nullable()->default(0);
            $table->string('ng_beam_detector')->nullable()->default(0);
            $table->text('catatan_beam_detector')->nullable();
            $table->string('photo_beam_detector')->nullable();
            $table->string('ok_push_button')->nullable()->default(0);
            $table->string('ng_push_button')->nullable()->default(0);
            $table->text('catatan_push_button')->nullable();
            $table->string('photo_push_button')->nullable();
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
        Schema::dropIfExists('tt_check_sheet_facps');
    }
};
