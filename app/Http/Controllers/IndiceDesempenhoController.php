<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Models\IndiceDesempenho;
use App\Models\Fornecedor;

class IndiceDesempenhoController extends Controller
{
    public function index(Request $request) {
        
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'indice_desempenho-'.$d.'.xls';
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
            $indice_desempenho = IndiceDesempenho::where('fornecedor', 'like', "%".$pesquisa."%")
                                        ->orWhere('cnpj', 'like', "%".$pesquisa."%")
                                        ->orWhere('ano_referencia', 'like', "%".$pesquisa."%")->paginate(1000);

        } else if($pesquisa != '' && $tipo == 'exportar') {
            $indice_desempenho = IndiceDesempenho::where('fornecedor', 'like', "%".$pesquisa."%")
                                        ->orWhere('cnpj', 'like', "%".$pesquisa."%")
                                        ->orWhere('ano_referencia', 'like', "%".$pesquisa."%")->all();

            return view('indice_desempenho.exportar', compact('indice_desempenho'));
        } else if($tipo == 'exportar') {
            $indice_desempenho = IndiceDesempenho::all();
            return view('indice_desempenho.exportar', compact('indice_desempenho'));

        }else{
            $indice_desempenho = IndiceDesempenho::paginate(10);
        }



        if($request->is('api/indice_desempenho')){
            return response()->json([$indice_desempenho],200);
        }else{
            return view('indice_desempenho.index', compact('indice_desempenho','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'indice_desempenho-'.$d.'.xls';
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
            $indice_desempenho = IndiceDesempenho::where('fornecedor', 'like', "%".$pesquisa."%")
                                        ->orWhere('cnpj', 'like', "%".$pesquisa."%")
                                        ->orWhere('ano_referencia', 'like', "%".$pesquisa."%")->get();
        } else  {
            $indice_desempenho = IndiceDesempenho::all();
        }
        return view('indice_desempenho.exportar', compact('indice_desempenho'));
    } 
    public function novo() {

        $fornecedores = Fornecedor::class::get();

        return view('indice_desempenho.form', compact('fornecedores'));
    }
    public function editar($id) {

        $cliente = IndiceDesempenho::find($id);
        return view('indice_desempenho.form');
    }
    public function salvar(ClienteRequest $request) {

        $ehvalido = $request->validated();
        if($request->id != '') {
            $cliente = IndiceDesempenho::find($request->id);
            $cliente->update($request->all());
        } else {
            $cliente = IndiceDesempenho::create($request->all());
        }

        return redirect('/indice_desempenho/editar/'. $cliente->id)->with('success', 'Salvo com sucesso!');
    }

    public function deletar(Request $request, $id) {
        $cliente = IndiceDesempenho::find($id);
        if(!empty($cliente)){
            $cliente->delete();
            return redirect('indice_desempenho')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('indice_desempenho')->with('danger', 'Registro não encontrado!');
        }
    }
}
