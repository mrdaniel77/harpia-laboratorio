<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribuicoes_lider extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'lider_id',
    ];

    

    
}
