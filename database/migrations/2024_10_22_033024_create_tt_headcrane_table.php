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
        Schema::create('tt_check_sheet_head_cranes', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('headcrane_number');
            $table->string('cross_travelling');
            $table->text('catatan_cross_travelling')->nullable();
            $table->string('photo_cross_travelling');
            $table->string('long_travelling');
            $table->text('catatan_long_travelling')->nullable();
            $table->string('photo_long_travelling');
            $table->string('button_up');
            $table->text('catatan_button_up')->nullable();
            $table->string('photo_button_up');
            $table->string('button_down');
            $table->text('catatan_button_down')->nullable();
            $table->string('photo_button_down');
            $table->string('button_push');
            $table->text('catatan_button_push')->nullable();
            $table->string('photo_button_push');
            $table->string('wire_rope');
            $table->text('catatan_wire_rope')->nullable();
            $table->string('photo_wire_rope');
            $table->string('block_hook');
            $table->text('catatan_block_hook')->nullable();
            $table->string('photo_block_hook');
            $table->string('hom');
            $table->text('catatan_hom')->nullable();
            $table->string('photo_hom');
            $table->string('emergency_stop');
            $table->text('catatan_emergency_stop')->nullable();
            $table->string('photo_emergency_stop');
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
        Schema::dropIfExists('tt_headcrane');
    }
};
