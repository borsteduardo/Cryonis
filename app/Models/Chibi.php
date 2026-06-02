<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chibi extends Model
{
    use HasFactory;

    protected $table = 'chibis';

    protected $fillable = [
        'nome',
        'raridade',
        'descricao',
        'observacoes'
    ];

    // Relacionamento: Um chibi pode estar no inventário de várias pessoas
    public function inventarios()
    {
        return $this->hasMany(InventarioChibi::class, 'chibi_id');
    }
}