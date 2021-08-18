<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Plano_auditoriaRequest;
use App\Models\Plano_auditoria;
use App\Models\Colaborador;
use App\Models\Setor;

use PDF;

class Plano_auditoriaController extends Controller
{
    
    public function index(Request $request) {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
       
        $pesquisa = $request->pesquisa;

        if($pesquisa != '') {
            $plano_auditoria = Plano_auditoria::with('colaborador','autorizador','cargo')
                                    ->where('assi_autorizado','like', "%".$pesquisa."%")
                                    ->orWhere('assi_autorizador','like', "%".$pesquisa."%")
                                    ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                        $query->where('nome','like', "%".$pesquisa."%");
                                    })
                                    ->paginate(10);
        } else {
            $plano_auditoria = Plano_auditoria::with('colaborador')->paginate(10);
            
        }
        return view('plano_auditoria.index', compact('plano_auditoria','pesquisa'));
    } 
    public function gerar_pdf($id){
        
        $plano_auditoria = Plano_auditoria::find($id);
        view()->share('plano_auditoria', $plano_auditoria);
        $pdf_doc = PDF::loadView('plano_auditoria.gerar_pdf', $plano_auditoria);
        
        return $pdf_doc->stream('plano_auditoria.pdf');
    }
    public function novo() {
        $setores = Setor::select('setor', 'id')->get();
        $colaboradores_id = Colaborador::select('nome', 'id')->get();

        return view('plano_auditoria.form', compact('colaboradores_id','setores'));
    }
    public function editar($id) {
        $setores = Setor::select('setor', 'id')->get();
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $plano_auditoria = Plano_auditoria::find($id);
        
        return view('plano_auditoria.form', compact('plano_auditoria','setores','colaboradores_id'));
    }
    public function salvar(Plano_auditoriaRequest $request) {

       
        $ehvalido = $request->validated();
        if($request->id != '') {
            $plano_auditoria = Plano_auditoria::find($request->id);
            $plano_auditoria->update($request->all());
        } else {
            
            $plano_auditoria = Plano_auditoria::create($request->all());
        }

        return redirect('/plano_auditoria/editar/'. $plano_auditoria->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $plano_auditoria = Plano_auditoria::find($id);
        if(!empty($plano_auditoria)){
            $plano_auditoria->delete();
            return redirect('plano_auditoria')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('plano_auditoria')->with('danger', 'Registro não encontrado!');
        }
    }
}
