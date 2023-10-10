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
        Schema::create('tt_check_sheet_tembins', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('tembin_number');
            $table->string('master_link');
            $table->text('catatan_master_link')->nullable();
            $table->string('photo_master_link');
            $table->string('body_tembin');
            $table->text('catatan_body_tembin')->nullable();
            $table->string('photo_body_tembin');
            $table->string('mur_baut');
            $table->text('catatan_mur_baut')->nullable();
            $table->string('photo_mur_baut');
            $table->string('shackle');
            $table->text('catatan_shackle')->nullable();
            $table->string('photo_shackle');
            $table->string('hook_atas');
            $table->text('catatan_hook_atas')->nullable();
            $table->string('photo_hook_atas');
            $table->string('pengunci_hook_atas');
            $table->text('catatan_pengunci_hook_atas')->nullable();
            $table->string('photo_pengunci_hook_atas');
            $table->string('mata_chain');
            $table->text('catatan_mata_chain')->nullable();
            $table->string('photo_mata_chain');
            $table->string('hook_bawah');
            $table->text('catatan_hook_bawah')->nullable();
            $table->string('photo_hook_bawah');
            $table->string('pengunci_hook_bawah');
            $table->text('catatan_pengunci_hook_bawah')->nullable();
            $table->string('photo_pengunci_hook_bawah');
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
        Schema::dropIfExists('tt_check_sheet_tembins');
    }
};
