<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReclamacoesRequest;
use App\Models\Reclamacao;
use App\Models\Colaborador;

class ReclamacoesController extends Controller
{

    public function index(Request $request) {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'reclamacoes-'.$d.'.xls';
            // Configurações header para forçar o download
            header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header ("Cache-Control: no-cache, must-revalidate");
            header ("Pragma: no-cache");
            //header ("Content-type: application/x-msexcel; charset=UTF-8");
            header ("Content-type: application/vnd.ms-excel; charset=UTF-8");
            header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
            header ("Content-Description: PHP Generated Data" );
            echo "\xEF\xBB\xBF"; //UTF-8 BOM

        }

        if($pesquisa != '' && $tipo != 'exportar') {
            $reclamacao = Reclamacao::with('colaborador', 'rep_analise')
                                    ->where('descricao','like', "%".$pesquisa."%")
                                    ->orWhere('reclamante','like', "%".$pesquisa."%")
                                    ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                        $query->where('nome','like', "%".$pesquisa."%");
                                    })->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $reclamacao = Reclamacao::with('colaborador', 'rep_analise')
                                    ->where('descricao','like', "%".$pesquisa."%")
                                    ->orWhere('reclamante','like', "%".$pesquisa."%")
                                    ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                        $query->where('nome','like', "%".$pesquisa."%");
                                    })->all();
            return view('reclamacoes.exportar', compact('reclamacao'));
        } else if($tipo == 'exportar') {
            $reclamacao = Reclamacao::all();
            return view('reclamacoes.exportar', compact('reclamacao'));

        }else{
            $reclamacao = Reclamacao::paginate(10);
        }

        if($request->is('api/reclamacoes')){
            return response()->json([$reclamacao],200);
        }else{
            return view('reclamacoes.index', compact('reclamacao','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'reclamacoes-'.$d.'.xls';
        // Configurações header para forçar o download
        header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header ("Cache-Control: no-cache, must-revalidate");
        header ("Pragma: no-cache");
        header ("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
        header ("Content-Description: PHP Generated Data" );
        echo "\xEF\xBB\xBF";


        if($pesquisa != '') {
            $reclamacao = Reclamacao::with('colaborador', 'rep_analise')
                                    ->where('descricao','like', "%".$pesquisa."%")
                                    ->orWhere('reclamante','like', "%".$pesquisa."%")
                                    ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                        $query->where('nome','like', "%".$pesquisa."%");
                                    })->get();
        } else  {
            $reclamacao = Reclamacao::all();
        }
        return view('reclamacoes.exportar', compact('reclamacao'));
    } 

    public $tipo_manifestacao = ['Reclamação', 'Sugestão'];
    public $tipo_nc = ['Sim', 'Não'];

    public function novo() {
        $rep_analise_id = Colaborador::select('nome', 'id')->get();
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $tipo_manifestacao = $this->tipo_manifestacao;
        $tipo_nc = $this->tipo_nc;
        return view('reclamacoes.form', compact('tipo_manifestacao', 'rep_analise_id','tipo_nc','colaboradores_id'));
    }
    public function editar($id) {
        $rep_analise_id = Colaborador::select('nome', 'id')->get();
        $tipo_nc = $this->tipo_nc;
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $reclamacao = Reclamacao::find($id);
        $tipo_manifestacao = $this->tipo_manifestacao;
        
        return view('reclamacoes.form', compact('reclamacao','tipo_nc', 'tipo_manifestacao', 'rep_analise_id', 'colaboradores_id'));
    }
    public function salvar(ReclamacoesRequest $request) {

        $ehvalido = $request->validated();
        if($request->id != '') {
            $reclamacao = Reclamacao::find($request->id);
            $reclamacao->update($request->all());
        } else {
            
            $reclamacao = Reclamacao::create($request->all());
        }

        return redirect('/reclamacoes/editar/'. $reclamacao->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $reclamacao = Reclamacao::find($id);
        if(!empty($reclamacao)){
            $reclamacao->delete();
            return redirect('reclamacoes')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('reclamacoes')->with('danger', 'Registro não encontrado!');
        }
    }
}



