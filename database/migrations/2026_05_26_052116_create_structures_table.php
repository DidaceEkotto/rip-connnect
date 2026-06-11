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
        Schema::create('structures', function (Blueprint $table) {
            $table->id();

            
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign('user_id')->references("id")->on("users")->onDelete("cascade");
            $table->string("name");
            $table->string("slug");
            $table->string("logo")->nullable();
            $table->string("pays")->default("1");//Cameroun
            $table->string('region')->nullable();
            $table->string("ville")->nullable();
            $table->string("indicatif")->default("+237");
            $table->string("telephone");
            $table->string("numero_cni")->nullable();
            $table->string("image_cni_recto")->nullable();
            $table->string("image_cni_verso")->nullable();
            $table->string("numero_contribuable")->nullable();
            $table->string("pdf_contribuable")->nullable();
            $table->string("numero_registre_commerce")->nullable();
            $table->string("pdf_registre_commerce")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structures');
    }
};
