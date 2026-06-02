<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioChibi extends Model
{
    use HasFactory;

    protected $table = 'inventario_chibis';

    protected $fillable = [
        'user_id',
        'chibi_id',
        'quantidade'
    ];

    // Relacionamento: Saber quem é o dono desse chibi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento: Saber qual chibi é este (para puxar nome, raridade, etc)
    public function chibi()
    {
        return $this->belongsTo(Chibi::class, 'chibi_id');
    }
}