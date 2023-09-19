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
        Schema::create('tt_check_sheet_tabung_co2s', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('tabung_number');
            $table->string('cover');
            $table->text('catatan_cover')->nullable();
            $table->string('photo_cover');
            $table->string('tabung');
            $table->text('catatan_tabung')->nullable();
            $table->string('photo_tabung');
            $table->string('lock_pin');
            $table->text('catatan_lock_pin')->nullable();
            $table->string('photo_lock_pin');
            $table->string('segel_lock_pin');
            $table->text('catatan_segel_lock_pin')->nullable();
            $table->string('photo_segel_lock_pin');
            $table->string('kebocoran_regulator_tabung');
            $table->text('catatan_kebocoran_regulator_tabung')->nullable();
            $table->string('photo_kebocoran_regulator_tabung');
            $table->string('selang');
            $table->text('catatan_selang')->nullable();
            $table->string('photo_selang');
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
        Schema::dropIfExists('tt_check_sheet_tabung_co2s');
    }
};
