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
        Schema::create('tt_check_sheet_head_crane', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengecekan');
            $table->string('npk');
            $table->string('headcrane_number');
            $table->unsignedBigInteger('id_prosedur_item_check'); // Kolom foreign key
            $table->foreign('id_prosedur_item_check')->references('id')->on('tm_prosedur_item_check')
                ->onUpdate('cascade') // Aksi saat parent di-update
                ->onDelete('cascade'); // Aksi saat parent dihapuss
            $table->string('check');
            $table->string('catatan')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('tt_check_sheet_head_crane');
    }
};
