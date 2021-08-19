<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Responsa_autoRequest;
use App\Models\Responsa_auto;
use App\Models\Colaborador;
use App\Models\Cargo;

use PDF;

class Responsa_autoController extends Controller
{
    
    public function index(Request $request) {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $cargo_id = Cargo::select('cargo', 'id')->get();
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'responsa_auto-'.$d.'.xls';
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
            $responsa_auto = Responsa_auto::where('cargo_id', 'like', "%".$pesquisa."%")
                                ->orWhere('colaborador_id', 'like', "%".$pesquisa."%")
                                ->orWhere('autorizador_id', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $responsa_auto = Responsa_auto::where('cargo_id', 'like', "%".$pesquisa."%")
                                ->orWhere('colaborador_id', 'like', "%".$pesquisa."%")
                                ->orWhere('autorizador_id', 'like', "%".$pesquisa."%")->all();
            return view('responsa_auto.exportar', compact('responsa_auto'));
        } else if($tipo == 'exportar') {
            $responsa_auto = Responsa_auto::all();
            return view('responsa_auto.exportar', compact('responsa_auto'));

        }else{
            $responsa_auto = Responsa_auto::paginate(10);
        }

            

        if($request->is('api/responsa_auto')){
            return response()->json([$registro],200);
        }else{
            return view('responsa_auto.index', compact('responsa_auto','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'responsa_auto-'.$d.'.xls';
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
            $responsa_auto = Responsa_auto::where('cargo_id', 'like', "%".$pesquisa."%")
                                ->orWhere('colaborador_id', 'like', "%".$pesquisa."%")
                                ->orWhere('autorizador_id', 'like', "%".$pesquisa."%")->get();
        } else  {
            $responsa_auto = Responsa_auto::all();
        }
        
        return view('responsa_auto.exportar', compact('responsa_auto'));
    } 
    public function gerar_pdf($id){
        
        $responsa_auto = Responsa_auto::find($id);
        view()->share('responsa_auto', $responsa_auto);
        $pdf_doc = PDF::loadView('responsa_auto.gerar_pdf', $responsa_auto);
        
        return $pdf_doc->stream('responsa_auto.pdf');
    }
    public function novo() {
        $cargos = Cargo::select('cargo', 'id')->get();
        $autorizador_id = Colaborador::select('nome', 'id')->get();
        $colaboradores_id = Colaborador::select('nome', 'id')->get();

        return view('responsa_auto.form', compact('autorizador_id','colaboradores_id','cargos'));
    }
    public function editar($id) {
        $cargos = Cargo::select('cargo', 'id')->get();
        $autorizador_id = Colaborador::select('nome', 'id')->get();
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $responsa_auto = Responsa_auto::find($id);
        
        return view('responsa_auto.form', compact('responsa_auto', 'autorizador_id', 'colaboradores_id','cargos'));
    }
    public function salvar(Responsa_autoRequest $request) {

        if(count($request->responsabilidades) > 0) {
            $request['responsabilidades'] = json_encode($request->responsabilidades);
        }
        //dd($request->all());
        $ehvalido = $request->validated();
        if($request->id != '') {
            $responsa_auto = Responsa_auto::find($request->id);
            $responsa_auto->update($request->all());
        } else {
            
            $responsa_auto = Responsa_auto::create($request->all());
        }

        return redirect('/responsa_auto/editar/'. $responsa_auto->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $responsa_auto = Responsa_auto::find($id);
        if(!empty($responsa_auto)){
            $responsa_auto->delete();
            return redirect('responsa_auto')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('responsa_auto')->with('danger', 'Registro não encontrado!');
        }
    }
}
