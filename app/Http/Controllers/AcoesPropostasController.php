<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AcoesPropostasRequest;
use App\Models\AcoesPropostas;
use App\Models\Novo_Rnc;

use PDF;

class AcoesPropostasController extends Controller
{  
        public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'acoes_propostas-'.$d.'.xls';
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
            $acoes_propostas = AcoesPropostas::where('nome', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $acoes_propostas = AcoesPropostas::where('nome', 'like', "%".$pesquisa."%")->all();
            return view('acoes_propostas.exportar', compact('acoes_propostas'));
        } else if($tipo == 'exportar') {
            $acoes_propostas = AcoesPropostas::all();
            return view('acoes_propostas.exportar', compact('acoes_propostas'));

        }else{
            $acoes_propostas = AcoesPropostas::paginate(10);
        }



        if($request->is('api/acoes_propostas')){
            return response()->json([$acoes_propostas],200);
        }else{
            return view('acoes_propostas.index', compact('acoes_propostas','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'acoes_propostas-'.$d.'.xls';
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
            $acoes_propostas = AcoesPropostas::where('nome', 'like', "%".$pesquisa."%")->get();
        } else  {
            $acoes_propostas = AcoesPropostas::all();
        }
        return view('acoes_propostas.exportar', compact('acoes_propostas'));
    } 

        public function novo() {

        $novos_rncs = Novo_Rnc::select('responsavel')->get();    


        return view('acoes_propostas.form', compact('novos_rncs'));
        }

        public function editar($id) {

            $novos_rncs = Novo_Rnc::select('responsavel')->get(); 

            $acoes_propostas = AcoesPropostas::find($id);

            return view('acoes_propostas.form', compact('novos_rncs', 'acoes_propostas'));
        }

        public function salvar(AcoesPropostasRequest $request) {

            $ehvalido = $request->validated();

            if($request->id != '') {
                $acoes_propostas = AcoesPropostas::find($request->id);
                $acoes_propostas->update($request->all());
            } else {
                $acoes_propostas = AcoesPropostas::create($request->all());
            }
            return redirect('/acoes_propostas/editar/'. $acoes_propostas->id)->with('success', 'Salvo com sucesso!');
        }
        public function deletar($id) {
            $acoes_propostas = AcoesPropostas::find($id);
            if(!empty($acoes_propostas)){
                $acoes_propostas->delete();
                return redirect('acoes_propostas')->with('success', 'Deletado com sucesso!');
            } else {
                return redirect('acoes_propostas')->with('danger', 'Registro não encontrado!');
            }
    }
    public function list() {
        $acoes_propostas = AcoesPropostas::paginate();

        return response()->json($acoes_propostas, 200);
    }
        
}

