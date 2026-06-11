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
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("entreprise_id")->nullable();
            $table->foreign("entreprise_id")->references("id")->on("entreprises")->onDelete("cascade");
            $table->string("admin_id")->nullable();
            $table->string("title");
            $table->string("slug");
            $table->string("auteur")->nullable();
            $table->string("maison_edition")->nullable();
            $table->string("nombre_de_pages")->nullable();
            $table->string("nombre_de_chapitre")->nullable();
            $table->string("anne_de_parution")->nullable();
            $table->string("image")->nullable();
            $table->string("gratuit_ou_payant")->nullable();
            $table->string("prix")->nullable();
            $table->string("lien")->nullable();
            $table->string("libreries")->nullable();
            $table->string("documents")->nullable();//PDF ou WORD
            $table->text("content")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};
