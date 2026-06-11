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
        Schema::create('deces', function (Blueprint $table) {
            $table->id();
            $table->string("identifiant");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger("morgue_id")->nullable();
            $table->foreign("morgue_id")->references("id")->on("morgues")->onDelete("cascade");
            $table->string("admin_id")->nullable();
            $table->string("photo")->nullable();
            $table->string("nom");
            $table->string("prenom")->nullable();
            $table->string("genre")->nullable();
            $table->string("date_naissance")->nullable();
            $table->string("date_dece")->nullable();
            $table->string("heure_leve")->nullable();
            $table->string("age")->nullable();
            $table->string("promotion")->nullable();
            $table->string("date_leve")->nullable();
            $table->string("lieux_deces")->nullable();
            $table->string("cause_deces")->nullable();
            $table->string("date_debut_promotion")->nullable();
            $table->string("date_fin_promotion")->nullable();
            $table->string("programme_obseque_pdf")->nullable();
            $table->text("details_ceremonie")->nullable();
            $table->string("lien_brouillons")->nullable();
            $table->string("lien_valider")->default("non");//quand l'annonce est ok par l'utilisateur
            $table->text("description")->nullable();
            $table->string("status")->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deces');
    }
};
