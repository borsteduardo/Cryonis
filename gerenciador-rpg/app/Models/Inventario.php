<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ficha_id', 'quantidade'];

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'ficha_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}