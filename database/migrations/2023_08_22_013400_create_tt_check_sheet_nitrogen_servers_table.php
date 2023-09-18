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
        Schema::create('tt_check_sheet_nitrogen_servers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('tabung_number');
            $table->string('operasional');
            $table->text('catatan_operasional')->nullable();
            $table->string('photo_operasional');
            $table->string('selector_mode');
            $table->text('catatan_selector_mode')->nullable();
            $table->string('photo_selector_mode');
            $table->string('pintu_tabung');
            $table->text('catatan_pintu_tabung')->nullable();
            $table->string('photo_pintu_tabung');
            $table->string('pressure_pilot');
            $table->text('catatan_pressure_pilot')->nullable();
            $table->string('photo_pressure_pilot');
            $table->string('pressure_no1');
            $table->text('catatan_pressure_no1')->nullable();
            $table->string('photo_pressure_no1');
            $table->string('pressure_no2');
            $table->text('catatan_pressure_no2')->nullable();
            $table->string('photo_pressure_no2');
            $table->string('pressure_no3');
            $table->text('catatan_pressure_no3')->nullable();
            $table->string('photo_pressure_no3');
            $table->string('pressure_no4');
            $table->text('catatan_pressure_no4')->nullable();
            $table->string('photo_pressure_no4');
            $table->string('pressure_no5');
            $table->text('catatan_pressure_no5')->nullable();
            $table->string('photo_pressure_no5');
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
        Schema::dropIfExists('tt_check_sheet_nitrogen_servers');
    }
};
