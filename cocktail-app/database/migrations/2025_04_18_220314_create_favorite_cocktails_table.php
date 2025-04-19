<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorite_cocktails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cocktail_id'); // ID del cóctel en la API
            $table->string('name');
            $table->string('category');
            $table->string('glass_type');
            $table->text('instructions');
            $table->string('image_url');
            $table->text('ingredients'); // Almacenaremos JSON con los ingredientes
            $table->timestamps();
            
            // Evitar duplicados: un usuario no puede guardar el mismo cóctel dos veces
            $table->unique(['user_id', 'cocktail_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_cocktails');
    }
};