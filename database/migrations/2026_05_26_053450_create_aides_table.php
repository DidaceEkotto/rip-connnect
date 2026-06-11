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
        Schema::create('aides', function (Blueprint $table) {
            $table->id();
            $table->string("admin_id");
            $table->string("titre");
            $table->string("slug");
            $table->string("type")->nullable();
            $table->string("image")->nullable();
            $table->text("content");
            $table->string("piece_jointe")->nullable();
            $table->string("status")->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aides');
    }
};
