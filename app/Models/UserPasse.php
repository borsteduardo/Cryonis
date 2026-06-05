<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPasse extends Model
{
    use HasFactory;

    protected $table = 'user_passes';

    protected $fillable = [
        'user_id',
        'passe_id',
        'xp_atual',
        'nivel_atual',
        'premium_desbloqueado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function passe()
    {
        return $this->belongsTo(Passe::class, 'passe_id');
    }
}