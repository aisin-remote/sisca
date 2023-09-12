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
        Schema::create('check_sheet_co2s', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('apar_number');
            $table->string('pressure');
            $table->text('catatan_pressure')->nullable();
            $table->string('photo_pressure');
            $table->string('hose');
            $table->text('catatan_hose')->nullable();
            $table->string('photo_hose');
            $table->string('corong');
            $table->text('catatan_corong')->nullable();
            $table->string('photo_corong');
            $table->string('tabung');
            $table->text('catatan_tabung')->nullable();
            $table->string('photo_tabung');
            $table->string('regulator');
            $table->text('catatan_regulator')->nullable();
            $table->string('photo_regulator');
            $table->string('lock_pin');
            $table->text('catatan_lock_pin')->nullable();
            $table->string('photo_lock_pin');
            $table->string('berat_tabung');
            $table->text('catatan_berat_tabung')->nullable();
            $table->string('photo_berat_tabung');
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
        Schema::dropIfExists('check_sheet_co2s');
    }
};
