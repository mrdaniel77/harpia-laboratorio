<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CargosRequest;
use App\Models\Cargo;
use App\Models\Rep;

class CargosController extends Controller
{   public $tipo_formacao = [' Ensino Fundamental', 'Ensino Médio', 'Graduação','Pós-Graduação'];

    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;


        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'cargos-'.$d.'.xls';
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
            $cargo = Cargo::where('cargo', 'like', "%".$pesquisa."%")
                                ->orWhere('tipo_formacao', 'like', "%".$pesquisa."%")
                                ->orWhere('responsabilidades', 'like', "%".$pesquisa."%")
                                ->orWhere('qualificacao', 'like', "%".$pesquisa."%")
                                ->orWhere('treinamentos', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $cargo = Cargo::where('cargo', 'like', "%".$pesquisa."%")
                                ->orWhere('tipo_formacao', 'like', "%".$pesquisa."%")
                                ->orWhere('responsabilidades', 'like', "%".$pesquisa."%")
                                ->orWhere('qualificacao', 'like', "%".$pesquisa."%")
                                ->orWhere('treinamentos', 'like', "%".$pesquisa."%")->all();
            return view('cargos.exportar', compact('cargo'));
        } else if($tipo == 'exportar') {
            $cargo = Cargo::all();
            return view('cargos.exportar', compact('cargo'));

        }else{
            $cargo = Cargo::paginate(10);
        }

            

        if($request->is('api/cargos')){
            return response()->json([$registro],200);
        }else{
            return view('cargos.index', compact('cargo','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'cargos-'.$d.'.xls';
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
            $cargo = Cargo::where('cargo', 'like', "%".$pesquisa."%")
                                ->orWhere('tipo_formacao', 'like', "%".$pesquisa."%")
                                ->orWhere('responsabilidades', 'like', "%".$pesquisa."%")
                                ->orWhere('qualificacao', 'like', "%".$pesquisa."%")
                                ->orWhere('treinamentos', 'like', "%".$pesquisa."%")->get();
        } else  {
            $cargo = Cargo::all();
        }
        
        return view('cargos.exportar', compact('cargo'));
    } 

    public function novo() {
        $tipo_formacao = $this->tipo_formacao;
        return view('cargos.form', compact('tipo_formacao'));
    }

    public function salvar(CargosRequest $request) {

        $responsabilidades = $request->responsabilidades;
        unset($request['responsabilidades']);

        $novas_responsabilidades = [];
        $nova_responsabilidade = [];

        $tipo_formacao = $this->tipo_formacao;
        $ehValido = $request->validated();
        $message = '';
        
        if($request->id == '') {
            $cargo = Cargo::create($request->all());
            
            $message = 'Salvo com sucesso';
        } else {
            $message = 'Alterado com sucesso'; 
            $cargo = Cargo::find($request->id);
            $cargo->update($request->all());
            Rep::where('cargo_id', '=', $cargo->id)->delete();
        }

        foreach($responsabilidades as $resp) {
            $nova_responsabilidade['nome'] = $resp;
            $nova_responsabilidade['cargo_id'] = $cargo->id;
            $novas_responsabilidades[] = Rep::create($nova_responsabilidade);                
        }

        if($request->is('api/cargos/salvar')){
            return response()->json(['success'=> "Salvo com sucesso"],200);
        }else{
            return redirect('cargos/editar/' . $cargo->id)->with('success', $message);
        }
    } 
    public function editar($id) {
        $tipo_formacao = $this->tipo_formacao;
        $cargo = Cargo::find($id);
        $cargos = Cargo::select('id', 'cargo')->get();
        $cargo = Cargo::with('responsabilidades')->find($id);
        return view('cargos.form', compact('cargo', 'cargos','tipo_formacao')); 
    }
    public function deletar(Request $request, $id) {
        $cargo = Cargo::find($id);
        if(!empty($cargo)){
            Rep::where('cargo_id','=', $id)->delete();
            $cargo->delete();
            if($request->path == `api/cargos/deletar/${id}`){
                return response()->json(['success' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('cargos')->with('success', 'Deletado com sucesso!');
            }
        } else {
            if($request->path == `api/cargos/deletar/${id}`){
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }else{
                return redirect('cargos')->with('danger', 'Registro não encontrado!');
            }
        }
    }
    public function responsabilidades($cargo = '') {
        $responsabilidades = Rep::select('id', 'nome')->get();
        if($cargo != '') {
            $responsabilidades = Rep::select('id', 'nome')->where('cargo_id', '=', $cargo)->get();
        }
        
        return response()->json(['responsabilidades' => $responsabilidades]);
    }
}
