<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('missoes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('passe_id')->nullable()->constrained('passes')->onDelete('cascade');
        $table->string('titulo');
        $table->string('descricao')->nullable();
        $table->enum('tipo', ['diaria', 'semanal', 'mensal', 'temporada']);
        $table->integer('xp_recompensa');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missaos');
    }
};
