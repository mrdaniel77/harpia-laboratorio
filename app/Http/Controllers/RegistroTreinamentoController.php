<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistroTreinamentoRequest;
use App\Models\RegistroTreinamento;

class RegistroTreinamentoController extends Controller
{  

        public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'registro_treinamento-'.$d.'.xls';
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
            $registro_treinamento = RegistroTreinamento::where('titulo', 'like', "%".$pesquisa."%")
                                                        ->orWhere('carga_horaria', 'like', "%".$pesquisa."%")
                                                        ->orWhere('data_inicial', 'like', "%".$pesquisa."%") 
                                                        ->orWhere('data_final', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $registro_treinamento = RegistroTreinamento::where('titulo', 'like', "%".$pesquisa."%")
                                                        ->orWhere('carga_horaria', 'like', "%".$pesquisa."%")
                                                        ->orWhere('data_inicial', 'like', "%".$pesquisa."%") 
                                                        ->orWhere('data_final', 'like', "%".$pesquisa."%")->all();
            return view('registro_treinamento.exportar', compact('registro_treinamento'));
        } else if($tipo == 'exportar') {
            $registro_treinamento = RegistroTreinamento::all();
            return view('registro_treinamento.exportar', compact('registro_treinamento'));

        }else{
            $registro_treinamento = RegistroTreinamento::paginate(10);
        }

            

        if($request->is('api/registro_treinamento')){
            return response()->json([$registro],200);
        }else{
            return view('registro_treinamento.index', compact('registro_treinamento','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'registro_treinamento-'.$d.'.xls';
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
            $registro_treinamento = RegistroTreinamento::where('titulo', 'like', "%".$pesquisa."%")
                                                        ->orWhere('carga_horaria', 'like', "%".$pesquisa."%")
                                                        ->orWhere('data_inicial', 'like', "%".$pesquisa."%") 
                                                        ->orWhere('data_final', 'like', "%".$pesquisa."%")->get();
        } else  {
            $registro_treinamento = RegistroTreinamento::all();
        }
        
        return view('registro_treinamento.exportar', compact('registro_treinamento'));
    } 
        public function novo() {
        return view('registro_treinamento.form');
        }

        public function editar($id) {

            $registro_treinamento = RegistroTreinamento::select('titulo', 'carga_horaria', 'data_inicial','data_final', 'conteudo')->get();

            $registro_treinamento = RegistroTreinamento::find($id);
            return view('registro_treinamento.form', compact('registro_treinamento'));
        }

        public function salvar(Request $request) {

            //$ehvalido = $request->validated();

            if($request->id != '') {
                $registro_treinamento = RegistroTreinamento::find($request->id);
                $registro_treinamento->update($request->all());
            } else {
                $registro_treinamento = RegistroTreinamento::create($request->all());
            }
            return redirect('/registro_treinamento/editar/'. $registro_treinamento->id)->with('success', 'Salvo com sucesso!');
        }
        public function deletar($id) {
            $registro_treinamento = RegistroTreinamento::find($id);
            if(!empty($registro_treinamento)){
                $registro_treinamento->delete();
                return redirect('registro_treinamento')->with('success', 'Deletado com sucesso!');
            } else {
                return redirect('registro_treinamento')->with('danger', 'Registro não encontrado!');
            }
    }
    public function list() {
        $registro_treinamento = RegistroTreinamento::paginate();

        return response()->json($registro_treinamento, 200);
    }
        
}


