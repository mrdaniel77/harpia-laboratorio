<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnaliseCriticaRequest;
use App\Models\Analise_critica;
use App\Models\Colaborador;

class AnaliseCriticaController extends Controller
{

	public function index(Request $request) 
	{
        $colaboradores = Colaborador::select('id','nome')->get();

		$pesquisa = $request->pesquisa;
		$tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'analise_critica-'.$d.'.xls';
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
            $analise_critica = Analise_critica::where('colaborador_id', 'like', "%".$pesquisa."%")
                                               ->orWhere('metodos_definidos', 'like', "%".$pesquisa."%")
                                               ->orWhere('pessoal_qualificado', 'like', "%".$pesquisa."%")
                                               ->orWhere('capacidade_recursos', 'like', "%".$pesquisa."%")->paginate(1000);

        } else if($pesquisa != '' && $tipo == 'exportar') {
            $analise_critica = Analise_critica::where('colaborador_id', 'like', "%".$pesquisa."%")
                                                ->orWhere('metodos_definidos', 'like', "%".$pesquisa."%")
                                                ->orWhere('pessoal_qualificado', 'like', "%".$pesquisa."%")
                                                ->orWhere('capacidade_recursos', 'like', "%".$pesquisa."%")->all();

            return view('analise_critica.exportar', compact('analise_critica', 'colaboradores'));
        } else if($tipo == 'exportar') {
            $analise_critica = Analise_critica::all();
            return view('analise_critica.exportar', compact('analise_critica', 'colaboradores'));

        }else{
            $analise_critica = Analise_critica::paginate(10);
        }



        if($request->is('api/analise_critica')){
            return response()->json([$analise_critica],200);
        }else{
            return view('analise_critica.index', compact('analise_critica','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'analise_critica-'.$d.'.xls';
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
            $analise_critica = Analise_critica::where('colaborador_id', 'like', "%".$pesquisa."%")
                                                ->orWhere('metodos_definidos', 'like', "%".$pesquisa."%")
                                                ->orWhere('pessoal_qualificado', 'like', "%".$pesquisa."%")
                                                ->orWhere('capacidade_recursos', 'like', "%".$pesquisa."%")->get();
        } else  {
            $analise_critica = Analise_critica::all();
        }
        return view('analise_critica.exportar', compact('analise_critica'));
    } 
	public function novo() {
		$colaboradores = Colaborador::select('id','nome')->get();
		return view('analise_critica.form', compact('colaboradores'));
	}
	public function editar($id) {
		$colaboradores = Colaborador::select('id','nome')->get();
		$analise_criticas = Analise_critica::find($id);
		return view('analise_critica.form', compact('analise_criticas','colaboradores'));
	}
	public function salvar(AnaliseCriticaRequest $request) {
		
	
		$ehValido = $request->validated();


		if($request->id != '') {
			$analise_critica = Analise_critica::find($request->id);
			$analise_critica->update($request->all());
		} else {
			$analise_critica = Analise_critica::create($request->all());
		}
		return redirect('/analise_critica/editar/'. $analise_critica->id)->with('success', 'Salvo com sucesso!');
	}
	public function deletar($id) {
		$analise_critica = Analise_critica::find($id);
		if(!empty($analise_critica)){
			$analise_critica->delete();
			return redirect('analise_critica')->with('success', 'Deletado com sucesso!');
		} else {
			return redirect('analise_critica')->with('danger', 'Registro não encontrado!');
		}
	}
}