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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('committee_member_name');
            $table->string('cipsMemberId');
            $table->string('designation');
            $table->string('imgPath')->nullable();
            $table->unsignedBigInteger('committee_id');
            $table->string('committee_type');
            $table->boolean('showcase')->default(0);
            $table->foreign('committee_id')
                ->references('id')
                ->on('committees')
                ->onDelete('cascade');
            $table->integer('priority')->nullable();
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
        Schema::dropIfExists('members');
    }
};
