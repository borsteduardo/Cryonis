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
    Schema::create('passe_niveis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('passe_id')->constrained('passes')->onDelete('cascade');
        $table->integer('nivel');
        $table->integer('xp_necessario');
        $table->string('recompensa_tipo'); // 'moeda', 'giro', 'chibi', 'ficha', etc.
        $table->unsignedBigInteger('recompensa_id')->nullable(); // ID do chibi/ficha (nulo se for moeda/giro)
        $table->integer('quantidade')->default(1);
        $table->boolean('is_premium')->default(false); // true se for recompensa só do passe pago
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passe_nivels');
    }
};
