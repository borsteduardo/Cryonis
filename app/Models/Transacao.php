<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    // Se o Laravel tiver pluralizado errado no banco, descomente a linha abaixo e ajuste o nome
    protected $table = 'transacoes';

    protected $fillable = [
        'user_id',
        'tipo',
        'valor',
        'descricao',
    ];
}