<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMissao extends Model
{
    use HasFactory;

    protected $table = 'user_missoes';

    protected $fillable = [
        'user_id',
        'missao_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function missao()
    {
        return $this->belongsTo(Missao::class, 'missao_id');
    }
}