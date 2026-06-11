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
        Schema::create('temoignages', function (Blueprint $table) {
            $table->id();
            $table->string("identifiant");
            $table->string("admin_id")->nullable();
            $table->unsignedBigInteger("dece_id")->nullable();
            $table->foreign('dece_id')->references('id')->on("deces")->onDelete("cascade");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign('user_id')->references('id')->on("users")->onDelete("cascade");
            $table->string("nom");
            $table->string("prenom")->nullable();
            $table->string("email")->nullable();
            $table->string("pays")->nullable();
            $table->string("ville")->nullable();
            $table->text("temoignage");
            $table->string("view")->default("non");
            $table->string("status")->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temoignages');
    }
};
