<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano_auditoria extends Model
{

    use HasFactory;
    protected $fillable = [
        'referencia',
        'setor_organizacao',
        'telefone',
        'email',
        'avaliacao',
        'doc_base',
        'requisitos',
        'objetivo',
        'abg_programa',
        'riscos',
        'data_abertura',
        'data_encerramento',
        'relato',
        'metodo',
        'avaliador_lider',
        'avaliador_especialista',
        'setor_avaliador',
        'item',
        'matriz',
        'ensaio',
        'metodo_escopo',
        'setor_escopo',
        'data_plano',
        'atividade',
        'processo',
        'item_plano',
        'itens_normativos',
        'auditores',
        'auditor_lider_plano'


    ];


    public function atribuicoes_lider()
    {
        return $this->hasMany(Atribuicoes_lider::class, 'lider_id', 'id');
    }

    
    public function setores()
    {
        return $this->hasOne(Setores::class, 'id', 'setor_id');
    }

}

