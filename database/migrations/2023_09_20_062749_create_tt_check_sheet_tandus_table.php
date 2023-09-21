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
        Schema::create('tt_check_sheet_tandus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('tandu_number');
            $table->string('kunci_pintu');
            $table->text('catatan_kunci_pintu')->nullable();
            $table->string('photo_kunci_pintu');
            $table->string('pintu');
            $table->text('catatan_pintu')->nullable();
            $table->string('photo_pintu');
            $table->string('sign');
            $table->text('catatan_sign')->nullable();
            $table->string('photo_sign');
            $table->string('hand_grip');
            $table->text('catatan_hand_grip')->nullable();
            $table->string('photo_hand_grip');
            $table->string('body');
            $table->text('catatan_body')->nullable();
            $table->string('photo_body');
            $table->string('engsel');
            $table->text('catatan_engsel')->nullable();
            $table->string('photo_engsel');
            $table->string('kaki');
            $table->text('catatan_kaki')->nullable();
            $table->string('photo_kaki');
            $table->string('belt');
            $table->text('catatan_belt')->nullable();
            $table->string('photo_belt');
            $table->string('rangka');
            $table->text('catatan_rangka')->nullable();
            $table->string('photo_rangka');
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
        Schema::dropIfExists('tt_check_sheet_tandus');
    }
};
