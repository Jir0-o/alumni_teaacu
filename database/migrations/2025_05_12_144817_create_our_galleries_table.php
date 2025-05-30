<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('our_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('gallery_image');
            $table->boolean('is_active')->default(1);
            $table->integer('type')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_galleries');
    }
};
