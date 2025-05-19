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
        Schema::create('event_pics', function (Blueprint $table) {
            $table->id();
            $table->string('imgPath');
            $table->unsignedBigInteger('event_id');
            $table->boolean('isSlider')->default(0);
            $table->foreign('event_id')
                ->references('id')
                ->on('event_galleries')
                ->onDelete('cascade');
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
        Schema::dropIfExists('event_pics');
    }
};
