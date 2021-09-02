<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FornecedoresRequest;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    public $tipos = ['Serviço', 'Produto' ];


    public function index(Request $request) {
        $pesquisa = $request->pesquisa;     
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'fornecedores-'.$d.'.xls';
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
            $fornecedor = Fornecedor::where('tipo', 'like', "%".$pesquisa."%")
                                    ->orWhere('cnpj', 'like', "%".$pesquisa."%")
                                    ->orWhere('razao_social', 'like', "%".$pesquisa."%")
                                    ->orWhere('telefone', 'like', "%".$pesquisa."%")
                                    ->orWhere('email', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $fornecedor = Fornecedor::where('tipo', 'like', "%".$pesquisa."%")
                                    ->orWhere('cnpj', 'like', "%".$pesquisa."%")
                                    ->orWhere('razao_social', 'like', "%".$pesquisa."%")
                                    ->orWhere('telefone', 'like', "%".$pesquisa."%")
                                    ->orWhere('email', 'like', "%".$pesquisa."%")->all();
            return view('fornecedores.exportar', compact('fornecedor'));
        } else if($tipo == 'exportar') {
            $fornecedor = Fornecedor::all();
            return view('fornecedores.exportar', compact('fornecedor'));

        }else{
            $fornecedor = Fornecedor::paginate(10);
        }

            

        if($request->is('api/fornecedores')){
            return response()->json([$registro],200);
        }else{
            return view('fornecedores.index', compact('fornecedor','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'fornecedores-'.$d.'.xls';
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

            $fornecedor = Fornecedor::where('tipo', 'like', "%".$pesquisa."%")
                                    ->orWhere('cnpj', 'like', "%".$pesquisa."%")
                                    ->orWhere('razao_social', 'like', "%".$pesquisa."%")
                                    ->orWhere('telefone', 'like', "%".$pesquisa."%")
                                    ->orWhere('email', 'like', "%".$pesquisa."%")->get();
        } else  {
            $fornecedor = Fornecedor::all();

        }
        
        return view('fornecedores.exportar', compact('fornecedor'));
    } 
    public function novo() {
        $tipos = $this->tipos;
        return view('fornecedores.form', compact('tipos'));
    }
    public function editar($id) {
        $tipos = $this->tipos;
        $fornecedor = Fornecedor::find($id);
        return view('fornecedores.form', compact('fornecedor', 'tipos'));
    }
    public function salvar(FornecedoresRequest $request) {
        
        $ehValido = $request->validated();

        if($request->id != '') {
            $fornecedor = Fornecedor::find($request->id);
            $fornecedor->update($request->all());
        } else {
            $fornecedor = Fornecedor::create($request->all());
        }
        return redirect('/fornecedores/editar/'. $fornecedor->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar(Request $request, $id) {
        $fornecedor = Fornecedor::find($id);
        if(!empty($fornecedor)){
            $fornecedor->delete();
            if($request->path == `api/fornecedores/deletar/${id}`){
                return response()->json(['sucesso' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('fornecedores')->with('success', 'Deletado com sucesso!');
            }
        } else {
            if($request->path == `api/fornecedores/deletar/${id}`){
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }else{
                return redirect('fornecedores')->with('danger', 'Registro não encontrado!');
            }
        }
    }
}



