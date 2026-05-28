<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao'];

    // Diz ao Laravel que uma Categoria "tem muitas" Fichas
    public function fichas()
    {
        return $this->hasMany(Ficha::class);
    }
}