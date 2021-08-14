<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MapaControleRegistrosRequest;
use App\Models\MapaControleRegistros;
use App\Models\Lista_mestra;
use App\Models\Cargo;

use PDF;

class MapaControleRegistrosController extends Controller
{
    public function index(Request $request) {
        $lista_mestra = Lista_mestra::select('codigo', 'id')->get();
        $n_lista_mestra_id = Lista_mestra::select('titulo', 'id')->get();
        $cargo = Cargo::select('cargo', 'id')->get();
        $c_cargo_id = Cargo::select('cargo', 'id')->get();
        
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'mapa_controle-'.$d.'.xls';
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
            $mapa_controle_registros = MapaControleRegistros::where('nome', 'like', "%".$pesquisa."%")
            ->orWhere('codigo', 'like', "%".$pesquisa."%")
            ->orWhere('responsavel', 'like', "%".$pesquisa."%")
            ->orWhere('data', 'like', "%".$pesquisa."%")->paginate(1000);

        } else if($pesquisa != '' && $tipo == 'exportar') {
            $mapa_controle_registros = MapaControleRegistros::where('nome', 'like', "%".$pesquisa."%")
            ->orWhere('codigo', 'like', "%".$pesquisa."%")
            ->orWhere('responsavel', 'like', "%".$pesquisa."%")
            ->orWhere('data', 'like', "%".$pesquisa."%")->all();
            
            return view('mapa_controle.exportar', compact('mapa_controle_registros'));
        } else if($tipo == 'exportar') {
            $mapa_controle_registros = MapaControleRegistros::all();
            return view('mapa_controle.exportar', compact('mapa_controle_registros'));

        }else{
            $mapa_controle_registros = MapaControleRegistros::paginate(10);
        }
        
        if($request->is('api/mapa_controle')){
            return response()->json([$mapa_controle_registros],200);
        }else{
            return view('mapa_controle.index', compact('mapa_controle_registros','pesquisa'));
        }
    }
    
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'mapa_controle-'.$d.'.xls';
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
            $mapa_controle_registros = MapaControleRegistros::where('nome', 'like', "%".$pesquisa."%")->get();
        } else  {
            $mapa_controle_registros = MapaControleRegistros::all();
        }
        return view('mapa_controle.exportar', compact('mapa_controle_registros'));
    } 

    public function novo() {
        $lista_mestra = Lista_mestra::select('codigo', 'id')->get();
        $n_lista_mestra_id = Lista_mestra::select('titulo', 'id')->get();
        $cargo = Cargo::select('cargo', 'id')->get();
        $c_cargo_id = Cargo::select('cargo', 'id')->get();
        $acesso = Cargo::select('cargo', 'id')->get();

        return view('mapa_controle.form', compact('acesso','lista_mestra', 'n_lista_mestra_id','cargo','c_cargo_id'));
    }
    public function editar($id) {
        $lista_mestra = Lista_mestra::select('codigo', 'id')->get();
        $n_lista_mestra_id = Lista_mestra::select('titulo', 'id')->get();
        $cargo = Cargo::select('cargo', 'id')->get();
        $c_cargo_id = Cargo::select('cargo', 'id')->get();

        $mapa_controle_registros = MapaControleRegistros::find($id);
       
      
        return view('mapa_controle.form', compact('lista_mestra', 'n_lista_mestra_id','cargo','c_cargo_id','mapa_controle_registros'));
    }
    public function salvar(MapaControleRegistrosRequest $request) {
        
        if($request->acesso != '') {
            $request['acesso'] = json_encode($request->acesso);
        }
        if($request->coleta != '') {
            $request['coleta'] = json_encode($request->coleta);
        }

        $ehvalido = $request->validated();
        if($request->id != '') {
            $mapa_controle_registros = MapaControleRegistros::find($request->id);
            $mapa_controle_registros->update($request->all());
        } else {
            $mapa_controle_registros = MapaControleRegistros::create($request->all());
        }

        return redirect('/mapa_controle/editar/'. $mapa_controle_registros->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $mapa_controle_registros = MapaControleRegistros::find($id);
        if(!empty($mapa_controle_registros)){
            $mapa_controle_registros->delete();
            return redirect('mapa_controle')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('mapa_controle')->with('danger', 'Registro não encontrado!');
        }
    }
}

