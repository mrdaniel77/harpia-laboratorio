<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lista_mestra;
use App\Models\Cargo;

class MapaControleRegistros extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'acesso',
        'coleta',
        'armazenamento',
        'indexacao',
        'tempo_retencao',
        'descarte',
        'responsavel',
        'data'
    ];

    public function Lista_mestra(){
        return $this->hasOne(Lista_mestra::class, 'id', 'codigo_id');
    }

    public function n_Lista_mestra_id(){
        return $this->hasOne(Lista_mestra::class, 'id', 'n_Lista_mestra_id');
    }

    public function Cargo(){
        return $this->hasOne(Cargo::class, 'id', 'acesso_id');
    }

    public function c_Cargo_id(){
        return $this->hasOne(Lista_mestra::class, 'id', 'c_Cargo_id');
    }
}
