<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasseNivel extends Model
{
    use HasFactory;

    protected $table = 'passe_niveis';

    protected $fillable = [
        'passe_id',
        'nivel',
        'xp_necessario',
        'recompensa_tipo',
        'recompensa_id',
        'quantidade',
        'is_premium'
    ];

    public function passe()
    {
        return $this->belongsTo(Passe::class, 'passe_id');
    }
}