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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("identifiant");
            $table->string("sku");
            $table->unsignedBigInteger("admin_id")->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger("entreprise_id")->nullable();
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->string("slug");
            $table->string("type_product")->default("cerceuil");//cerceuil, marbrerie
            $table->string('prix');
            $table->text('content')->nullable();
            $table->string("status")->default("0");//0=non visible, 1=visible
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
