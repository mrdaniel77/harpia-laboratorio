<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Plano_auditoriaRequest;
use App\Models\Plano_auditoria;
use App\Models\Colaborador;
use App\Models\Setor;
use App\Models\Atribuicoes_lider;


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
        $plano_auditoria = Plano_auditoria::with('atribuicoes_lider')->find($id);
        //dd($plano_auditoria);
        
        return view('plano_auditoria.form', compact('plano_auditoria','setores','colaboradores_id'));
    }
    public function salvar(Plano_auditoriaRequest $request) {

       
        $atribuicoes_lider = $request->atribuicoes_lider;
        unset($request['atribuicoes_lider']);

        if($request->avaliador_especialista && count($request->avaliador_especialista) > 0) {
            $request['avaliador_especialista'] = json_encode($request->avaliador_especialista);
        }
        
        $novas_atribuicoes_lider = [];
        $nova_atribuicoes_lider = [];


        $ehValido = $request->validated();
        $message = '';
        
        if($request->id == '') {
            $plano_auditoria = Plano_auditoria::create($request->all());
            
            $message = 'Salvo com sucesso';
        } else {
            $message = 'Alterado com sucesso'; 
            $plano_auditoria = Plano_auditoria::find($request->id);
            $plano_auditoria->update($request->all());
            Atribuicoes_lider::where('lider_id', '=', $plano_auditoria->id)->delete();
        }

        foreach($atribuicoes_lider as $atri) {
            $nova_atribuicoes_lider['nome'] = $atri;
            $nova_atribuicoes_lider['lider_id'] = $plano_auditoria->id;
            $novas_atribuicoes_lider[] = Atribuicoes_lider::create($nova_atribuicoes_lider);                
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


    public function atribuicoes_lider($plano_auditoria = '') {
        $atribuicoes_lider = Atribuicoes_lider::select('id', 'nome')->get();
        if($plano_auditoria != '') {
            $atribuicoes_lider = Atribuicoes_lider::select('id', 'nome')->where('lider_id', '=', $plano_auditoria)->get();
        }
        
        return response()->json(['atribuicoes_lider' => $atribuicoes_lider]);
    }
}
