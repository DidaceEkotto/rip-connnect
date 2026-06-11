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
        Schema::create('bannieres', function (Blueprint $table) {
            $table->id();
            $table->string("admin_id");
            $table->string("image")->nullable();
            $table->string("date_debut")->nullable();
            $table->string("date_fin")->nullable();
            $table->string("petit_text")->nullable();
            $table->string("grand_text")->nullable();
            $table->string("lien")->nullable();
            $table->string("text_bouton")->nullable();
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bannieres');
    }
};
