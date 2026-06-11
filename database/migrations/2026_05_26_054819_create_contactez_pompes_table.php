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
        Schema::create('contactez_pompes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger("entreprise_id")->nullable();
            $table->foreign("entreprise_id")->references("id")->on("entreprises")->onDelete("cascade");
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->string("indicatif")->default("+237");
            $table->string("telephone")->nullable();
            $table->string("email")->nullable();
            $table->string("read")->default("0");
            $table->string("type")->nullable();//pompe, annonce etc
            $table->string("resend")->default("0");//Quand une personne repond une message
            $table->text("message")->nullable();
            $table->text("message_reponse")->nullable();
            $table->date("date_read")->nullable();
            $table->date("date_reponse")->nullable();
            $table->string("cv")->nullable();
            $table->string("lettre_motivation")->nullable();
            $table->text("bref_description")->nullable();
            $table->string("status")->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactez_pompes');
    }
};
