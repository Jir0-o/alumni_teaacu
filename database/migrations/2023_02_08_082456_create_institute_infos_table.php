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
        Schema::create('institute_infos', function (Blueprint $table) {
            $table->id();
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')
            ->references('id')
            ->on('people')
            ->onDelete('cascade');
            $table->string('address')->nullable();
            $table->date('form')->nullable();
            $table->date('to')->nullable();

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
        Schema::dropIfExists('institute_infos');
    }
};
