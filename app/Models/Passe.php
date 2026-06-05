<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passe extends Model
{
    use HasFactory;

    protected $table = 'passes';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'ativo'
    ];

    protected function casts(): array
    {
        return [
            'data_inicio' => 'date',
            'data_fim' => 'date',
            'ativo' => 'boolean',
        ];
    }

    public function niveis()
    {
        return $this->hasMany(PasseNivel::class, 'passe_id');
    }

    public function missoes()
    {
        return $this->hasMany(Missao::class, 'passe_id');
    }
}