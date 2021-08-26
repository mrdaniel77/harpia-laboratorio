<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RetornoRequest;
use App\Models\Retorno;
use App\Models\Colaborador;
use App\Models\Reclamacao;

class RetornoController extends Controller
{
    

    public function index(Request $request) {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

            if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'retorno-'.$d.'.xls';
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
            $retorno = Retorno::where('nome', 'like', "%".$pesquisa."%")
                                ->orWhere('data_retorno', 'like', "%".$pesquisa."%")
                                ->orWhere('descricao', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $retorno = Retorno::where('nome', 'like', "%".$pesquisa."%")
                                ->orWhere('data_retorno', 'like', "%".$pesquisa."%")
                                ->orWhere('descricao', 'like', "%".$pesquisa."%")->all();
            return view('retorno.exportar', compact('retorno'));
        } else if($tipo == 'exportar') {
            $retorno = Retorno::all();
            return view('retorno.exportar', compact('retorno'));

        }else{
            $retorno = Retorno::paginate(10);
        }

            

        if($request->is('api/retorno')){
            return response()->json([$registro],200);
        }else{
            return view('retorno.index', compact('retorno','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'retorno-'.$d.'.xls';
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
            $retorno = Retorno::where('nome', 'like', "%".$pesquisa."%")
                                ->orWhere('data_retorno', 'like', "%".$pesquisa."%")
                                ->orWhere('descricao', 'like', "%".$pesquisa."%")->get();
        } else  {
            $retorno = Retorno::all();
        }
        
        return view('retorno.exportar', compact('retorno'));
    } 
    public function novo(Request $request) {
        $reclamacao_id = $request->reclamacao_id;
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
       
        return view('retorno.form',compact('colaboradores_id','reclamacao_id'));
    }
    public function editar(Request $request, $id) {
        $reclamacao_id = $request->reclamacao_id;
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $retorno = Retorno::find($id);
       
        return view('retorno.form', compact('retorno','colaboradores_id','reclamacao_id'));
    }
    public function salvar(RetornoRequest $request) {

        $ehvalido = $request->validated();
        if($request->id != '') {
            $retorno = Retorno::find($request->id);
            $retorno->update($request->all());
        } else {
            $retorno = Retorno::create($request->all());
        }
        return redirect('/retorno/editar/'. $retorno->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
            if(!empty($retorno)){
            $retorno->delete();
            return redirect('retorno')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('retorno')->with('danger', 'Registro não encontrado!');
        }
    }
}

