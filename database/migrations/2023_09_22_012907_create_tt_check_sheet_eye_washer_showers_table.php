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
        Schema::create('tt_check_sheet_eye_washer_showers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('eyewasher_number');
            $table->string('instalation_base');
            $table->text('catatan_instalation_base')->nullable();
            $table->string('photo_instalation_base');
            $table->string('pipa_saluran_air');
            $table->text('catatan_pipa_saluran_air')->nullable();
            $table->string('photo_pipa_saluran_air');
            $table->string('wastafel_eye_wash');
            $table->text('catatan_wastafel_eye_wash')->nullable();
            $table->string('photo_wastafel_eye_wash');
            $table->string('tuas_eye_wash');
            $table->text('catatan_tuas_eye_wash')->nullable();
            $table->string('photo_tuas_eye_wash');
            $table->string('kran_eye_wash');
            $table->text('catatan_kran_eye_wash')->nullable();
            $table->string('photo_kran_eye_wash');
            $table->string('tuas_shower');
            $table->text('catatan_tuas_shower')->nullable();
            $table->string('photo_tuas_shower');
            $table->string('sign');
            $table->text('catatan_sign')->nullable();
            $table->string('photo_sign');
            $table->string('shower_head');
            $table->text('catatan_shower_head')->nullable();
            $table->string('photo_shower_head');
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
        Schema::dropIfExists('tt_check_sheet_eye_washer_showers');
    }
};
