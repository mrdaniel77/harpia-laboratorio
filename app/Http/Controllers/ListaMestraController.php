<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista_mestra;
use App\Http\Requests\ListaMestraRequest;
use App\Models\Documento;

class ListaMestraController extends Controller
{

    public $tipo = ['Manual','Procedimento','Anexo','Instrução de uso/trabalho','Formulário'];

    public function index(Request $request) {

        $documento_relacionado = Documento::select('documento', 'id')->get();

        $pesquisa = $request->pesquisa;

        
        if($pesquisa != '') {
            $lista_mestras = Lista_mestra::where('codigo', 'like', "%".$pesquisa."%")->paginate(1000);
        } else {
            $lista_mestras = Lista_mestra::with('codigo')->paginate(10);
        }
        return view('lista_mestras.index', compact('lista_mestras','pesquisa', 'documento_relacionado'));
    } 

    public function novo() {

        
        $tipo = $this->tipo;

        $documento_relacionado = Documento::select('documento', 'id')->get();

        return view('lista_mestras.form', compact('tipo', 'documento_relacionado' ));
    }

    public function editar($id) {

        $tipo = $this->tipo;
        $lista_mestra = Lista_mestra::find($id);
        $documento_relacionado = Documento::select('documento', 'id')->get();

        return view('lista_mestras.form', compact('lista_mestra', 'tipo', 'documento_relacionado'));
    }
    public function salvar(ListaMestraRequest $request) {
        
        $ehValido = $request->validated();

        if($request->id != '') {
            $lista_mestra = Lista_mestra::find($request->id);
            $lista_mestra->update($request->all());
        } else {
            $lista_mestra = Lista_mestra::create($request->all());
        }
        return redirect('/lista_mestras/editar/'. $lista_mestra->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $lista_mestra = Lista_mestra::find($id);
        if(!empty($lista_mestra)){
            $lista_mestra->delete();
            return redirect('lista_mestras')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('lista_mestras')->with('danger', 'Registro não encontrado!');
        }
    }
}
