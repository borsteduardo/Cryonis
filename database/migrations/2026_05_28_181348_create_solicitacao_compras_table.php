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
        Schema::create('solicitacoes_compras', function (Blueprint $table) {
            $table->id();
            
            // Quem está querendo comprar
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Qual carta ele quer
            $table->foreignId('ficha_id')->constrained('fichas')->onDelete('cascade');
            
            // O estado do pedido
            $table->enum('status', ['pendente', 'aprovada', 'recusada'])->default('pendente');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacao_compras');
    }
};
