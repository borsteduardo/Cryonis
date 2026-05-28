<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoCompra extends Model
{
    use HasFactory;

    // Forçamos o nome da tabela caso o Laravel pluralize errado (ex: solicitacao_compras)
    protected $table = 'solicitacoes_compras';

    protected $fillable = ['user_id', 'ficha_id', 'status'];

    // Relacionamento com o Jogador (Comprador)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com a Carta (Ficha)
    public function ficha()
    {
        return $this->belongsTo(Ficha::class);
    }
}