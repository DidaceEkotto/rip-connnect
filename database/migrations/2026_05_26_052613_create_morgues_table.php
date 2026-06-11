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
        Schema::create('morgues', function (Blueprint $table) {
            $table->id();
            $table->string("identifiant");
            $table->string("admin_id");
            $table->string("nom");
            $table->string("slug");
            $table->string("logo")->nullable();
            $table->string("indicatif")->default("+237");
            $table->string("telephone")->nullable();
            $table->string("email")->nullable();
            $table->string("adresse")->nullable();
            $table->unsignedBigInteger("ville_id")->nullable();
            $table->foreign("ville_id")->references("id")->on("villes")->onDelete("cascade");
            $table->string("localisation")->nullable();
            $table->string("code_postal")->nullable();
            $table->string("pays")->nullable();
            $table->string("longitude")->nullable();
            $table->string("latitude")->nullable();
            $table->string("heure_ouverture")->nullable();
            $table->string("heure_fermeture")->nullable();
            $table->string("prix")->nullable();

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
        Schema::dropIfExists('morgues');
    }
};
