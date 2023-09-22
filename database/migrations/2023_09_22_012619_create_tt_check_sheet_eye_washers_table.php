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
        Schema::create('tt_check_sheet_eye_washers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('eyewasher_number');
            $table->string('pijakan');
            $table->text('catatan_pijakan')->nullable();
            $table->string('photo_pijakan');
            $table->string('pipa_saluran_air');
            $table->text('catatan_pipa_saluran_air')->nullable();
            $table->string('photo_pipa_saluran_air');
            $table->string('wastafel');
            $table->text('catatan_wastafel')->nullable();
            $table->string('photo_wastafel');
            $table->string('kran_air');
            $table->text('catatan_kran_air')->nullable();
            $table->string('photo_kran_air');
            $table->string('tuas');
            $table->text('catatan_tuas')->nullable();
            $table->string('photo_tuas');
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
        Schema::dropIfExists('tt_check_sheet_eye_washers');
    }
};
