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
        Schema::create('tt_check_sheet_chainblocks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('chainblock_number');
            $table->string('geared_trolley');
            $table->text('catatan_geared_trolley')->nullable();
            $table->string('photo_geared_trolley');
            $table->string('chain_geared_trolley_1');
            $table->text('catatan_chain_geared_trolley_1')->nullable();
            $table->string('photo_chain_geared_trolley_1');
            $table->string('chain_geared_trolley_2');
            $table->text('catatan_chain_geared_trolley_2')->nullable();
            $table->string('photo_chain_geared_trolley_2');
            $table->string('hooking_geared_trolly');
            $table->text('catatan_hooking_geared_trolly')->nullable();
            $table->string('photo_hooking_geared_trolly');
            $table->string('latch_hook_atas');
            $table->text('catatan_latch_hook_atas')->nullable();
            $table->string('photo_latch_hook_atas');
            $table->string('hook_atas');
            $table->text('catatan_hook_atas')->nullable();
            $table->string('photo_hook_atas');
            $table->string('hand_chain');
            $table->text('catatan_hand_chain')->nullable();
            $table->string('photo_hand_chain');
            $table->string('load_chain');
            $table->text('catatan_load_chain')->nullable();
            $table->string('photo_load_chain');
            $table->string('latch_hook_bawah');
            $table->text('catatan_latch_hook_bawah')->nullable();
            $table->string('photo_latch_hook_bawah');
            $table->string('hook_bawah');
            $table->text('catatan_hook_bawah')->nullable();
            $table->string('photo_hook_bawah');
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
        Schema::dropIfExists('tt_check_sheet_chainblock');
    }
};
