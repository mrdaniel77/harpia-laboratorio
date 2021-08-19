<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\C_temperaturaRequest;
use App\Models\C_temperatura;
use App\Models\Colaborador;
use App\Models\Equipamentos;

class C_temperaturaController extends Controller
{

    public function index(Request $request) {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $refrigerador = Equipamentos::select('equipamento', 'id')->get();
        $d_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'c_temperatura-'.$d.'.xls';
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
            $c_temperatura = C_temperatura::with('colaborador', 'd_colaborador_id', 'l_colaborador_id', 'c_colaborador_id', 'equipamento_id')
                                            ->where('dia','like', "%".$pesquisa."%")
                                            ->orWhere('hora','like', "%".$pesquisa."%")
                                            ->orWhere('observacoes','like', "%".$pesquisa."%")
                                            ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                                $query->where('nome','like', "%".$pesquisa."%");
                                            })->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $c_temperatura = C_temperatura::with('colaborador', 'd_colaborador_id', 'l_colaborador_id', 'c_colaborador_id', 'equipamento_id')
                                            ->where('dia','like', "%".$pesquisa."%")
                                            ->orWhere('hora','like', "%".$pesquisa."%")
                                            ->orWhere('observacoes','like', "%".$pesquisa."%")
                                            ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                                $query->where('nome','like', "%".$pesquisa."%");
                                            })->all();
            return view('c_temperatura.exportar', compact('c_temperatura'));
        } else if($tipo == 'exportar') {
            $c_temperatura = C_temperatura::all();
            return view('c_temperatura.exportar', compact('c_temperatura'));

        }else{
            $c_temperatura = C_temperatura::paginate(10);
        }

            

        if($request->is('api/c_temperatura')){
            return response()->json([$registro],200);
        }else{
            return view('c_temperatura.index', compact('c_temperatura','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'c_temperatura-'.$d.'.xls';
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
            $c_temperatura = C_temperatura::with('colaborador', 'd_colaborador_id', 'l_colaborador_id', 'c_colaborador_id', 'equipamento_id')
                                            ->where('dia','like', "%".$pesquisa."%")
                                            ->orWhere('hora','like', "%".$pesquisa."%")
                                            ->orWhere('observacoes','like', "%".$pesquisa."%")
                                            ->orWhereHas('colaborador', function($query) use ($pesquisa){
                                                $query->where('nome','like', "%".$pesquisa."%");
                                            })->get();
        } else  {
            $c_temperatura = C_temperatura::all();
        }
        
        return view('c_temperatura.exportar', compact('c_temperatura'));
    } 
    public function novo() {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $d_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $l_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $c_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $refrigerador = Equipamentos::select('equipamento', 'id')->get();

        return view('c_temperatura.form', compact('d_colaboradores_id', 'l_colaboradores_id','c_colaboradores_id','colaboradores_id','refrigerador'));
    }
    public function editar($id) {
        $colaboradores_id = Colaborador::select('nome', 'id')->get();
        $d_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $l_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $c_colaboradores_id = Colaborador::select('nome', 'id')->get();
        $refrigerador = Equipamentos::select('equipamento', 'id')->get();
        $colaboradores_id = Colaborador::select('nome', 'id')->get();

        $c_temperaturas = C_temperatura::find($id);
       
      
        return view('c_temperatura.form', compact('d_colaboradores_id', 'l_colaboradores_id','c_colaboradores_id','colaboradores_id','refrigerador', 'c_temperaturas'));
    }
    public function salvar(C_temperaturaRequest $request) {

        $ehvalido = $request->validated();
        if($request->id != '') {
            $c_temperatura = C_temperatura::find($request->id);
            $c_temperatura->update($request->all());
        } else {
            $c_temperatura = C_temperatura::create($request->all());
        }

        return redirect('/c_temperatura/editar/'. $c_temperatura->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $c_temperatura = C_temperatura::find($id);
        if(!empty($c_temperatura)){
            $c_temperatura->delete();
            return redirect('c_temperatura')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('c_temperatura')->with('danger', 'Registro não encontrado!');
        }
    }
}



