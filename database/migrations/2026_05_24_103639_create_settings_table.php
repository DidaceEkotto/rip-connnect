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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->string("name_entreprise");
            $table->string("slug");
            $table->string("logo")->nullable();
            $table->string("image_seo")->nullable();
            $table->string("fav_icone")->nullable();
            $table->string("indicatif")->default("237");
            $table->string("telephone")->nullable();
            $table->string("telephone_whatsapp")->nullable();
            $table->string("email")->nullable();
            $table->string("bp")->nullable();
            $table->string("ville")->nullable();
            $table->string("localisation")->nullable();
            $table->string("om")->nullable();
            $table->string("momo")->nullable();
            $table->string("rib")->nullable();//pour le compte bancaire
            $table->string("facebook")->nullable();
            $table->string("tiktok")->nullable();
            $table->string("instagram")->nullable();
            $table->string("youtube")->nullable();
            $table->string("linkdin")->nullable();
            $table->string("twitter")->nullable();
            $table->string("prix_abonnement")->nullable();
            $table->string("mode_maintenance")->default("non");
            $table->text("mot_clees")->nullable();
            $table->text("description")->nullable();
            $table->string("statut")->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
