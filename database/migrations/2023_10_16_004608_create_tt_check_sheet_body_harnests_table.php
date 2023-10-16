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
        Schema::create('tt_check_sheet_body_harnests', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('bodyharnest_number');
            $table->string('shoulder_straps');
            $table->text('catatan_shoulder_straps')->nullable();
            $table->string('photo_shoulder_straps');
            $table->string('hook');
            $table->text('catatan_hook')->nullable();
            $table->string('photo_hook');
            $table->string('buckles_waist');
            $table->text('catatan_buckles_waist')->nullable();
            $table->string('photo_buckles_waist');
            $table->string('buckles_chest');
            $table->text('catatan_buckles_chest')->nullable();
            $table->string('photo_buckles_chest');
            $table->string('leg_straps');
            $table->text('catatan_leg_straps')->nullable();
            $table->string('photo_leg_straps');
            $table->string('buckles_leg');
            $table->text('catatan_buckles_leg')->nullable();
            $table->string('photo_buckles_leg');
            $table->string('back_d_ring');
            $table->text('catatan_back_d_ring')->nullable();
            $table->string('photo_back_d_ring');
            $table->string('carabiner');
            $table->text('catatan_carabiner')->nullable();
            $table->string('photo_carabiner');
            $table->string('straps_rope');
            $table->text('catatan_straps_rope')->nullable();
            $table->string('photo_straps_rope');
            $table->string('shock_absorber');
            $table->text('catatan_shock_absorber')->nullable();
            $table->string('photo_shock_absorber');
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
        Schema::dropIfExists('tt_check_sheet_body_harnest');
    }
};
