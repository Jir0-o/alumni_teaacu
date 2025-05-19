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
        Schema::create('showcase_abouts', function (Blueprint $table) {
            $table->id();
            $table->longText('first_section')->nullable();
            $table->longText('second_section')->nullable();
            $table->longText('third_section')->nullable();
            $table->longText('fourth_section')->nullable();
            $table->boolean('isActive')->default(0);
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
        Schema::dropIfExists('showcase_abouts');
    }
};
