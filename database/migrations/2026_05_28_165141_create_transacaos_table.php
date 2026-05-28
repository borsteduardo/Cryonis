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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            
            // Relaciona a transação com um usuário específico. Se o usuário for apagado, as transações dele também somem (cascade).
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->enum('tipo', ['entrada', 'saida']); // Aceita apenas esses dois valores
            $table->decimal('valor', 10, 2); // Suporta valores de até 99.999.999,99
            $table->string('descricao'); // Ex: "Salário semanal", "Compra de arma"
            
            $table->timestamps(); // Cria as colunas created_at (Data da transação) e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacaos');
    }
};
