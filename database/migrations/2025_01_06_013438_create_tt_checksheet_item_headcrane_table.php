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
        Schema::create('tt_check_sheet_item_headcrane', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_sheet_id');
            $table->unsignedBigInteger('item_check_id');
            $table->string('check'); // Not Checked, Passed, Failed
            $table->string('catatan')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('check_sheet_id')->references('id')->on('tm_check_sheet_head_crane')->onDelete('cascade');
            $table->foreign('item_check_id')->references('id')->on('tm_item_check_head_crane')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_checksheet_item_headcrane');
    }
};
