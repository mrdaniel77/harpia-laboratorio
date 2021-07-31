<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MapaControleRegistrosRequest;
use App\Models\MapaControleRegistros;
use App\Models\Lista_mestra;
use App\Models\Cargo;

class MapaControleRegistrosController extends Controller
{
    public function index(Request $request) {
        $lista_mestra = Lista_mestra::select('codigo', 'id')->get();
        $n_lista_mestra_id = Lista_mestra::select('titulo', 'id')->get();
        $cargo = Cargo::select('cargo', 'id')->get();
        $c_cargo_id = Cargo::select('cargo', 'id')->get();

        $pesquisa = $request->pesquisa;

        if($pesquisa != '') {
            $mapa_controle_registros = MapaControleRegistros::with('lista_mestra', 'n_lista_mestra_id', 'cargo', 'c_cargo_id')
                                    ->where('armazenamento','like', "%".$pesquisa."%")
                                    ->orWhere('indexacao','like', "%".$pesquisa."%")
                                    ->orWhere('tempo_retencao','like', "%".$pesquisa."%")
                                    ->orWhere('descarte','like', "%".$pesquisa."%")
                                    ->orWhere('responsavel','like', "%".$pesquisa."%")
                                    ->orWhere('data','like', "%".$pesquisa."%")
                                    ->paginate(1000);
        } else {
            $mapa_controle_registros = MapaControleRegistros::with('lista_mestra', 'n_lista_mestra_id', 'cargo','c_cargo_id')->paginate(10);
            
        }
        return view('mapa_controle.index', compact('mapa_controle_registros','pesquisa'));
    } 
    public function novo() {
        $lista_mestra = Lista_mestra::select('codigo', 'id')->get();
        $n_lista_mestra_id = Lista_mestra::select('titulo', 'id')->get();
        $cargo = Cargo::select('cargo', 'id')->get();
        $c_cargo_id = Cargo::select('cargo', 'id')->get();
        

        return view('mapa_controle.form', compact('lista_mestra', 'n_lista_mestra_id','cargo','c_cargo_id'));
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

