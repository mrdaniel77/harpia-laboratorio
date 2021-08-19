<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano_auditoria extends Model
{

    use HasFactory;
    protected $fillable = [
        'setor_id'


    ];



    public function setores()
    {
        return $this->hasOne(Setores::class, 'id', 'setor_id');
    }

}

