<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('leadership_messages', function (Blueprint $table) {
            $table->id();
            $table->text('vc_message')->nullable();
            $table->string('vc_image')->nullable();

            $table->text('president_message')->nullable();
            $table->string('president_image')->nullable();

            $table->text('advisor_message')->nullable();
            $table->string('advisor_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadership_messages');
    }
};
