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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            
            // Conecta com o Jogador
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Conecta com a Carta (Ficha)
            $table->foreignId('ficha_id')->constrained('fichas')->onDelete('cascade');
            
            // Quantidade de cópias
            $table->integer('quantidade')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
