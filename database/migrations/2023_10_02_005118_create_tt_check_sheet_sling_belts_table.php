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
        Schema::create('tt_check_sheet_sling_belts', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('sling_number');
            $table->string('kelengkapan_tag_sling_belt');
            $table->text('catatan_kelengkapan_tag_sling_belt')->nullable();
            $table->string('photo_kelengkapan_tag_sling_belt');
            $table->string('bagian_pinggir_belt_robek');
            $table->text('catatan_bagian_pinggir_belt_robek')->nullable();
            $table->string('photo_bagian_pinggir_belt_robek');
            $table->string('pengecekan_lapisan_belt_1');
            $table->text('catatan_pengecekan_lapisan_belt_1')->nullable();
            $table->string('photo_pengecekan_lapisan_belt_1');
            $table->string('pengecekan_jahitan_belt');
            $table->text('catatan_pengecekan_jahitan_belt')->nullable();
            $table->string('photo_pengecekan_jahitan_belt');
            $table->string('pengecekan_permukaan_belt');
            $table->text('catatan_pengecekan_permukaan_belt')->nullable();
            $table->string('photo_pengecekan_permukaan_belt');
            $table->string('pengecekan_lapisan_belt_2');
            $table->text('catatan_pengecekan_lapisan_belt_2')->nullable();
            $table->string('photo_pengecekan_lapisan_belt_2');
            $table->string('pengecekan_aus');
            $table->text('catatan_pengecekan_aus')->nullable();
            $table->string('photo_pengecekan_aus');
            $table->string('hook_wire');
            $table->text('catatan_hook_wire')->nullable();
            $table->string('photo_hook_wire');
            $table->string('pengunci_hook');
            $table->text('catatan_pengunci_hook')->nullable();
            $table->string('photo_pengunci_hook');
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
        Schema::dropIfExists('tt_check_sheet_sling_belts');
    }
};
