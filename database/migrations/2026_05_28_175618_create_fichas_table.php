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
        Schema::create('fichas', function (Blueprint $table) {
            $table->id();
            
            // Relaciona a ficha a uma categoria (Pasta). Se a pasta for apagada, as cartas dentro dela também são apagadas.
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            
            // Atributos da Carta
            $table->string('titulo'); // Ex: "Zona de Interferência"
            $table->string('link_referencia')->nullable();
            $table->string('rank')->default('Comum');
            $table->text('descricao_logica')->nullable();
            $table->string('energia')->nullable(); // Ex: "20.000 p/uso"
            $table->text('observacoes')->nullable();
            $table->string('fuga_reacao')->nullable();
            $table->decimal('preco', 12, 2)->default(0); // Preço em Coins
            $table->string('usuario_exclusivo')->nullable(); // Para quem a carta é restrita
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas');
    }
};
