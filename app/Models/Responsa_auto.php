<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsa_auto extends Model
{
    use HasFactory;
    protected $fillable = [
        'colaborador_id',
        'autorizador_id',
        'assinatura_autorizado',
        'assinatura_autorizador',
        'cargo_id',
        'responsabilidades',
    ];


    public function colaborador()
    {
        return $this->hasOne(Colaborador::class, 'id', 'colaborador_id');
    }

    public function autorizador()
    {
        return $this->hasOne(Colaborador::class, 'id', 'autorizador_id');
    }
    public function cargo()
    {
        return $this->hasOne(Cargo::class, 'id', 'cargo_id');
    }
}
