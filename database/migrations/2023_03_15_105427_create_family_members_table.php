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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade');
            // $table->unsignedBigInteger('relation_type_id');
            // $table->foreign('relation_type_id')->references('id')->on('relation_types')->onDelete('cascade');
            $table->string('spouse');
            $table->integer('number_of_child');
            // $table->boolean('is_cips_member')->default(0);
            // $table->text('occupation')->nullable();
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
        Schema::dropIfExists('family_members');
    }
};
