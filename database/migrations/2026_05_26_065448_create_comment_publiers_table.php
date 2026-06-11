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
        Schema::create('comment_publiers', function (Blueprint $table) {
            $table->id();
            $table->string("admin_id");
            $table->string("image")->nullable();
            $table->text("content");
            $table->string("status")->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_publiers');
    }
};
