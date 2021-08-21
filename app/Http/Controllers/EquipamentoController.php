<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EquipamentoRequest;
use App\Models\Equipamentos;
use App\Models\Fornecedor;
use App\Models\Setor;

class EquipamentoController extends Controller
{  
        public $equipamento_proprio = ['Sim','Não'];
        public $tensao = ['110','220','Bivolt'];
        public $manual = ['Sim','Não'];
        public $produto_critico = ['Sim', 'Não'];
        public $materiais_referencia = ['MR', 'MRC'];
        public $materiais = ['Consumíveis', 'Reagente', 'Insumo', 'Materiais de Referência'];
        public $unidade = ['mg', 'g', 'kg', 'ml', 'l', 'un'];

    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'equipamentos-'.$d.'.xls';
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
            $equipamentos = Equipamentos::where('equipamento', 'like', "%".$pesquisa."%")
                                        ->orWhere('nome', 'like', "%".$pesquisa."%")
                                        ->orWhere('quantidade', 'like', "%".$pesquisa."%")
                                        ->orWhere('modelo', 'like', "%".$pesquisa."%")
                                        ->orWhere('codigo', 'like', "%".$pesquisa."%")
                                        ->orWhere('materiais', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $equipamentos = Equipamentos::where('equipamento', 'like', "%".$pesquisa."%")
                                        ->orWhere('nome', 'like', "%".$pesquisa."%")
                                        ->orWhere('quantidade', 'like', "%".$pesquisa."%")
                                        ->orWhere('modelo', 'like', "%".$pesquisa."%")
                                        ->orWhere('codigo', 'like', "%".$pesquisa."%")
                                        ->orWhere('materiais', 'like', "%".$pesquisa."%")->all();
            return view('equipamentos.exportar', compact('equipamentos'));
        } else if($tipo == 'exportar') {
            $equipamentos = Equipamentos::all();
            return view('equipamentos.exportar', compact('equipamentos'));

        }else{
            $equipamentos = Equipamentos::paginate(10);
        }

            

        if($request->is('api/equipamentos')){
            return response()->json([$registro],200);
        }else{
            return view('equipamentos.index', compact('equipamentos','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'equipamentos-'.$d.'.xls';
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
            $equipamentos = Equipamentos::where('equipamento', 'like', "%".$pesquisa."%")
                                        ->orWhere('nome', 'like', "%".$pesquisa."%")
                                        ->orWhere('quantidade', 'like', "%".$pesquisa."%")
                                        ->orWhere('modelo', 'like', "%".$pesquisa."%")
                                        ->orWhere('codigo', 'like', "%".$pesquisa."%")
                                        ->orWhere('materiais', 'like', "%".$pesquisa."%")->get();
        } else  {
            $equipamentos = Equipamentos::all();
        }
        
        return view('equipamentos.exportar', compact('equipamentos'));
    } 
    public function novo(Request $request) {
        $fornecedores = Fornecedor::select('id','razao_social')->get();
        $setor = Setor::select('id','setor')->get();
        $equipamento_proprio = $this->equipamento_proprio;
        $tensao = $this->tensao;
        $manual = $this->manual;

            $fornecedores = Fornecedor::select('id','razao_social')->get();
            $setor = Setor::select('id','setor')->get();
            $equipamento_proprio = $this->equipamento_proprio;
            $tensao = $this->tensao;
            $manual = $this->manual;
            $produto_critico = $this->produto_critico;
            $materiais_referencia = $this->materiais_referencia;
            $materiais = $this->materiais;
            $unidade = $this->unidade;

        return view('equipamentos.form', compact('materiais','unidade','materiais_referencia','produto_critico','equipamento_proprio', 'tensao', 'manual', 'fornecedores', 'setor'));
        }
    
    public function editar($id) {

            $equipamentos = Equipamentos::find($id);
            $fornecedores = Fornecedor::select('id','razao_social')->get();
            $setor = Setor::select('id','setor')->get();
            $equipamento_proprio = $this->equipamento_proprio;
            $tensao = $this->tensao;
            $manual = $this->manual;
            $produto_critico = $this->produto_critico;
            $materiais_referencia = $this->materiais_referencia;
            $materiais = $this->materiais;
            $unidade = $this->unidade;

            return view('equipamentos.form', compact('materiais','unidade','materiais_referencia','produto_critico','equipamentos', 'equipamento_proprio', 'tensao', 'manual', 'fornecedores', 'setor'));
        }
    
        public function salvar(EquipamentoRequest $request) {

        if($request->id != '') {

            $ehvalido = $request->validated();
            
            $equipamentos = Equipamentos::find($request->id);
            $equipamentos->update($request->all());
        } else {
            $equipamentos = Equipamentos::create($request->all());
        }
        if($request->is('api/equipamentos/salvar')){
            return response()->json(['success' => 'Salvo com sucesso!'],200);
        }else{
            return redirect('/equipamentos/editar/'. $equipamentos->id)->with('success', 'Salvo com sucesso!');
        }
        
    }
    public function deletar(Request $request, $id) {
        $equipamentos = Equipamentos::find($id);
        if(!empty($equipamentos)){
            $equipamentos->delete();
            if($request->path == `api/equipamentos/deletar/${id}`){
                return response()->json(['success' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('equipamentos')->with('success', 'Deletado com sucesso!');
            }
        } else {
            if($request->path == `api/equipamentos/deletar/${id}`){
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }else{
                return redirect('equipamentos')->with('danger', 'Registro não encontrado!');
            }
        }
    }
    public function list() {
        $equipamentos = Equipamentos::paginate();

        return response()->json($equipamentos, 200);
    }
        
}


