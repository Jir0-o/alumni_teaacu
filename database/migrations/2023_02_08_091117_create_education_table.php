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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('passing_year')->nullable();
            $table->string('result')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->string('education_level')->nullable();
            $table->string('major_subject')->nullable();
            $table->string('degree_title')->nullable();
            $table->string('education_institute')->nullable();
            $table->string('education_board_universities')->nullable();
            $table->timestamps();
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade');

            // $table->foreign('education_level_id')
            //     ->references('id')
            //     ->on('education_levels')
            //     ->onDelete('cascade');

            // $table->foreign('education_institute_id')
            //     ->references('id')
            //     ->on('education_institutes')
            //     ->onDelete('cascade');

            // $table->foreign('education_board_universities_id')
            //     ->references('id')
            //     ->on('education_board_universities')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('education');
    }
};
