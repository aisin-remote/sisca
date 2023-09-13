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
        Schema::create('tt_check_sheet_hydrant_indoor', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('hydrant_number');
            $table->string('pintu');
            $table->text('catatan_pintu')->nullable();
            $table->string('photo_pintu');
            $table->string('lampu');
            $table->text('catatan_lampu')->nullable();
            $table->string('photo_lampu');
            $table->string('emergency');
            $table->text('catatan_emergency')->nullable();
            $table->string('photo_emergency');
            $table->string('nozzle');
            $table->text('catatan_nozzle')->nullable();
            $table->string('photo_nozzle');
            $table->string('selang');
            $table->text('catatan_selang')->nullable();
            $table->string('photo_selang');
            $table->string('valve');
            $table->text('catatan_valve')->nullable();
            $table->string('photo_valve');
            $table->string('coupling');
            $table->text('catatan_coupling')->nullable();
            $table->string('photo_coupling');
            $table->string('pressure');
            $table->text('catatan_pressure')->nullable();
            $table->string('photo_pressure');
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
        Schema::dropIfExists('tt_check_sheet_hydrant_indoor');
    }
};
