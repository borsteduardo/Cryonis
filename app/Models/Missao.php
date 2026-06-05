<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Missao extends Model
{
    use HasFactory;

    protected $table = 'missoes';

    protected $fillable = [
        'passe_id',
        'titulo',
        'descricao',
        'tipo',
        'xp_recompensa'
    ];

    public function passe()
    {
        return $this->belongsTo(Passe::class, 'passe_id');
    }
}