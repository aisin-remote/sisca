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
        Schema::create('tt_check_sheet_sling_wires', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('sling_number');
            $table->string('serabut_wire');
            $table->text('catatan_serabut_wire')->nullable();
            $table->string('photo_serabut_wire');
            $table->string('bagian_wire_1');
            $table->text('catatan_bagian_wire_1')->nullable();
            $table->string('photo_bagian_wire_1');
            $table->string('bagian_wire_2');
            $table->text('catatan_bagian_wire_2')->nullable();
            $table->string('photo_bagian_wire_2');
            $table->string('kumpulan_wire_1');
            $table->text('catatan_kumpulan_wire_1')->nullable();
            $table->string('photo_kumpulan_wire_1');
            $table->string('diameter_wire');
            $table->text('catatan_diameter_wire')->nullable();
            $table->string('photo_diameter_wire');
            $table->string('kumpulan_wire_2');
            $table->text('catatan_kumpulan_wire_2')->nullable();
            $table->string('photo_kumpulan_wire_2');
            $table->string('hook_wire');
            $table->text('catatan_hook_wire')->nullable();
            $table->string('photo_hook_wire');
            $table->string('pengunci_hook');
            $table->text('catatan_pengunci_hook')->nullable();
            $table->string('photo_pengunci_hook');
            $table->string('mata_sling');
            $table->text('catatan_mata_sling')->nullable();
            $table->string('photo_mata_sling');
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
        Schema::dropIfExists('tt_check_sheet_sling_wires');
    }
};
