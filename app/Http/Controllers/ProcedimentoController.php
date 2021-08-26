<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProcedimentoRequest;
use App\Models\Procedimento;

class ProcedimentoController extends Controller
{
    
    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'procedimento-'.$d.'.xls';
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
            $procedimento = Procedimento::where('rev', 'like', "%".$pesquisa."%")
                                        ->orWhere('data', 'like', "%".$pesquisa."%") 
                                        ->orWhere('analista', 'like', "%".$pesquisa."%") 
                                        ->orWhere('lote', 'like', "%".$pesquisa."%") 
                                        ->orWhere('responsavel', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $procedimento = Procedimento::where('rev', 'like', "%".$pesquisa."%")
                                        ->orWhere('data', 'like', "%".$pesquisa."%") 
                                        ->orWhere('analista', 'like', "%".$pesquisa."%") 
                                        ->orWhere('lote', 'like', "%".$pesquisa."%") 
                                        ->orWhere('responsavel', 'like', "%".$pesquisa."%")->all();
            return view('procedimento.exportar', compact('procedimento'));
        } else if($tipo == 'exportar') {
            $procedimento = Procedimento::all();
            return view('procedimento.exportar', compact('procedimento'));

        }else{
            $procedimento = Procedimento::paginate(10);
        }



        if($request->is('api/procedimento')){
            return response()->json([$procedimento],200);
        }else{
            return view('procedimento.index', compact('procedimento','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'procedimento-'.$d.'.xls';
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
            $procedimento = Procedimento::where('rev', 'like', "%".$pesquisa."%")
                                        ->orWhere('data', 'like', "%".$pesquisa."%") 
                                        ->orWhere('analista', 'like', "%".$pesquisa."%") 
                                        ->orWhere('lote', 'like', "%".$pesquisa."%") 
                                        ->orWhere('responsavel', 'like', "%".$pesquisa."%")->get();
        } else  {
            $procedimento = Procedimento::all();
        }
        return view('procedimento.exportar', compact('procedimento'));
    } 
    public function novo() {
                
        return view('procedimento.form');
    }
    public function salvar(ProcedimentoRequest $request) {

        $ehValido = $request->validated();
        $message = '';

        if($request->id == '') {
            $procedimento = Procedimento::create($request->all());
            $message = 'Salvo com sucesso';
        } else {
            $message = 'Alterado com sucesso'; 
            $procedimento = Procedimento::find($request->id);
            $procedimento->update($request->all());
        }
        return redirect('procedimento/editar/' . $procedimento->id)->with('success', $message);
    } 
    public function editar($id) {
        $procedimento = Procedimento::find($id);
       
        
        return view('procedimento.form', compact('procedimento'));
    }
    public function deletar($id) {
        $procedimento = Procedimento::find($id);
        $procedimento->delete();

        return redirect('procedimento')->with('success', 'Deletado com sucesso!');
    }
}




