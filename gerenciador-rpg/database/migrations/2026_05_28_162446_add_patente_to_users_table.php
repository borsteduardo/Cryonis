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
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna 'patente' logo após a coluna 'email'.
            // Definimos um valor padrão ('Membro') para que todo novo cadastro receba essa patente inicial.
            $table->string('patente')->default('Membro')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove a coluna caso a gente precise desfazer a migração
            $table->dropColumn('patente');
        });
    }
};