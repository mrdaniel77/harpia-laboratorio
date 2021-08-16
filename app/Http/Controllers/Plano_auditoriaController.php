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
    
        $plano_auditoria = Plano_auditoria::find($id);
        
        return view('plano_auditoria.form', compact('plano_auditoria'));
    }
    public function salvar(Plano_auditoriaRequest $request) {

        if(count($request->responsabilidades) > 0) {
            $request['responsabilidades'] = json_encode($request->responsabilidades);
        }
        //dd($request->all());
        $ehvalido = $request->validated();
        if($request->id != '') {
            $responsa_auto = Responsa_auto::find($request->id);
            $responsa_auto->update($request->all());
        } else {
            
            $responsa_auto = Responsa_auto::create($request->all());
        }

        return redirect('/responsa_auto/editar/'. $responsa_auto->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $responsa_auto = Responsa_auto::find($id);
        if(!empty($responsa_auto)){
            $responsa_auto->delete();
            return redirect('responsa_auto')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('responsa_auto')->with('danger', 'Registro não encontrado!');
        }
    }
}
