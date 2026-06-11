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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string("admin")->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("entreprise_name");
            $table->string("slug");
            $table->string("type_entreprise")->nullable();
            $table->string("activite")->nullable();
            $table->string("logo")->nullable();
            $table->ipAddress("adresse_ip")->nullable();
            $table->string("longiture")->nullable();
            $table->string("latitude")->nullable();
            $table->string("numero_regitre_commerce")->nullable();
            $table->string("file_regitre_commerce")->nullable();
            $table->string("numero_registre_impot")->nullable();
            $table->string("file_registre_impot")->nullable();
            $table->string("numero_immatriculation")->nullable();
            $table->string("files_immatriculation")->nullable();
            $table->string("adresse")->nullable();
            $table->string("site_web")->nullable();
            $table->string("facebook")->nullable();
            $table->string("twitter")->nullable();
            $table->string("instagram")->nullable();
            $table->string("linkedin")->nullable();
            $table->string("tiktok")->nullable();
            $table->string("transfert_compte")->default("0");
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
        Schema::dropIfExists('entreprises');
    }
};
