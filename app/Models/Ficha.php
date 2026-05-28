<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id', 
        'titulo', 
        'link_referencia', 
        'rank', 
        'descricao_logica', 
        'energia', 
        'observacoes', 
        'fuga_reacao', 
        'preco', 
        'usuario_exclusivo'
    ];

    // Diz ao Laravel que uma Ficha "pertence a" uma Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}