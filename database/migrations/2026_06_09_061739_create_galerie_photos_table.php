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
        Schema::create('galerie_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('morgue_id')->constrained()->onDelete('cascade');
            $table->string('chemin');
            $table->string('legende')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galerie_photos');
    }
};
