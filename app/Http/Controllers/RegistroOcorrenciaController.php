<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistroOcorrenciaRequest;
use App\Models\RegistroOcorrencia;

class RegistroOcorrenciaController extends Controller
{
   

    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'registro_de_ocorrencia-'.$d.'.xls';
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
            $registro = RegistroOcorrencia::where('numero', 'like', "%".$pesquisa."%")
                                        ->orWhere('origem', 'like', "%".$pesquisa."%")
                                        ->orWhere('data_de_abertura', 'like', "%".$pesquisa."%")
                                        ->orWhere('descrever_correcao', 'like', "%".$pesquisa."%")
                                        ->orWhere('registro_de_AC_n', 'like', "%".$pesquisa."%")
                                        ->orWhere('parecer_tecnico', 'like', "%".$pesquisa."%")
                                        ->orWhere('observacoes', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $registro = RegistroOcorrencia::where('numero', 'like', "%".$pesquisa."%")
                                        ->orWhere('origem', 'like', "%".$pesquisa."%")
                                        ->orWhere('data_de_abertura', 'like', "%".$pesquisa."%")
                                        ->orWhere('descrever_correcao', 'like', "%".$pesquisa."%")
                                        ->orWhere('registro_de_AC_n', 'like', "%".$pesquisa."%")
                                        ->orWhere('parecer_tecnico', 'like', "%".$pesquisa."%")
                                        ->orWhere('observacoes', 'like', "%".$pesquisa."%")->all();
            return view('registro_de_ocorrencia.exportar', compact('registro'));
        } else if($tipo == 'exportar') {
            $registro = RegistroOcorrencia::all();
            return view('registro_de_ocorrencia.exportar', compact('registro'));

        }else{
            $registro = RegistroOcorrencia::paginate(10);
        }

            

        if($request->is('api/registro_de_ocorrencia')){
            return response()->json([$registro],200);
        }else{
            return view('registro_de_ocorrencia.index', compact('registro','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'registro_de_ocorrencia-'.$d.'.xls';
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
            $registro = RegistroOcorrencia::where('numero', 'like', "%".$pesquisa."%")
                                        ->orWhere('origem', 'like', "%".$pesquisa."%")
                                        ->orWhere('data_de_abertura', 'like', "%".$pesquisa."%")
                                        ->orWhere('descrever_correcao', 'like', "%".$pesquisa."%")
                                        ->orWhere('registro_de_AC_n', 'like', "%".$pesquisa."%")
                                        ->orWhere('parecer_tecnico', 'like', "%".$pesquisa."%")
                                        ->orWhere('observacoes', 'like', "%".$pesquisa."%")->get();
        } else  {
            $registro = RegistroOcorrencia::all();
        }
        
        return view('registro_de_ocorrencia.exportar', compact('registro'));
    } 

    public $tipos = ['serviço', 'produto', ];
    public $necessario_correcao_imediata = ['Sim', 'Não', ];

    public function novo() {
        $tipos = $this->tipos;
        $necessario_correcao_imediata = $this->necessario_correcao_imediata;
        return view('registro_de_ocorrencia.form', compact('tipos', 'necessario_correcao_imediata'));
    }
    public function editar($id) {
        $tipos = $this->tipos;
        $necessario_correcao_imediata = $this->necessario_correcao_imediata;
        $registro = RegistroOcorrencia::find($id);
        return view('registro_de_ocorrencia.form', compact('registro', 'tipos', 'necessario_correcao_imediata'));
    }
    public function salvar(RegistroOcorrenciaRequest $request) {
        
        //$ehValido = $request->validated();

        if($request->id != '') {
            $registro = RegistroOcorrencia::find($request->id);
            $registro->update($request->all());
        } else {
            $registro = RegistroOcorrencia::create($request->all());
        }
        return redirect('/registro_de_ocorrencia/editar/'. $registro->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $registro = RegistroOcorrencia::find($id);
        if(!empty($registro)){
            $registro->delete();
            return redirect('registro_de_ocorrencia')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('registro_de_ocorrencia')->with('danger', 'Registro não encontrado!');
        }
    }
}
