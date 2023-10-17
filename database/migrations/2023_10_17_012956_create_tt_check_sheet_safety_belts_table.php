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
        Schema::create('tt_check_sheet_safety_belts', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('safetybelt_number');
            $table->string('buckle');
            $table->text('catatan_buckle')->nullable();
            $table->string('photo_buckle');
            $table->string('seams');
            $table->text('catatan_seams')->nullable();
            $table->string('photo_seams');
            $table->string('reel');
            $table->text('catatan_reel')->nullable();
            $table->string('photo_reel');
            $table->string('shock_absorber');
            $table->text('catatan_shock_absorber')->nullable();
            $table->string('photo_shock_absorber');
            $table->string('ring');
            $table->text('catatan_ring')->nullable();
            $table->string('photo_ring');
            $table->string('torso_belt');
            $table->text('catatan_torso_belt')->nullable();
            $table->string('photo_torso_belt');
            $table->string('strap');
            $table->text('catatan_strap')->nullable();
            $table->string('photo_strap');
            $table->string('rope');
            $table->text('catatan_rope')->nullable();
            $table->string('photo_rope');
            $table->string('seam_protection_tube');
            $table->text('catatan_seam_protection_tube')->nullable();
            $table->string('photo_seam_protection_tube');
            $table->string('hook');
            $table->text('catatan_hook')->nullable();
            $table->string('photo_hook');
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
        Schema::dropIfExists('tt_check_sheet_safety_belts');
    }
};
