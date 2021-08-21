<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SetoresRequest;
use App\Models\Setor;

class SetoresController extends Controller
{
    
    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'setores-'.$d.'.xls';
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
            $setor = Setor::with('setor_pai', 'filhos')
                            ->where('setor','like', "%".$pesquisa."%")
                            ->orWhereHas('setor_pai', function($query) use ($pesquisa){
                            $query->where('setor','like', "%".$pesquisa."%");
                            })->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $setor = Setor::with('setor_pai', 'filhos')
                            ->where('setor','like', "%".$pesquisa."%")
                            ->orWhereHas('setor_pai', function($query) use ($pesquisa){
                            $query->where('setor','like', "%".$pesquisa."%");
                            })->all();
            return view('setores.exportar', compact('setor'));
        } else if($tipo == 'exportar') {
            $setor = Setor::all();
            return view('setores.exportar', compact('setor'));

        }else{
            $setor = Setor::paginate(10);
        }

            

        if($request->is('api/setores')){
            return response()->json([$registro],200);
        }else{
            return view('setores.index', compact('setor','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'setores-'.$d.'.xls';
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
            $setor = Setor::with('setor_pai', 'filhos')
                            ->where('setor','like', "%".$pesquisa."%")
                            ->orWhereHas('setor_pai', function($query) use ($pesquisa){
                            $query->where('setor','like', "%".$pesquisa."%");
                            })->get();
        } else  {
            $setor = Setor::all();
        }
        
        return view('setores.exportar', compact('setor'));
    } 
    public function novo(Request $request) {
       
        $setores = Setor::with('setor_pai','filhos')->get();
        if($request->is('api/setores/novo')){
            return response()->json([$setores],200);
        }else{
            return view('setores.form', compact('setores'));
        }
    }
    public function salvar(SetoresRequest $request) {
        
        $ehValido = $request->validated();
        $message = '';

        if($request->id == '') {
            $setor = Setor::create($request->all());
            $message = 'Salvo com sucesso';
        } else {
            $message = 'Alterado com sucesso'; 
            $setor = Setor::find($request->id);
            $setor->update($request->all());
        }
        if($request->is('api/setores/salvar')){
            return response()->json(['success' => 'Salvo com sucesso!'],200);
        }else{
            return redirect('setores/editar/' . $setor->id)->with('success', $message);
        }
    } 
    public function editar($id) {
        $setores = Setor::select('id', 'setor')->get();
        $setor = Setor::find($id);
        return view('setores.form', compact('setor', 'setores'));
    }
    public function deletar(Request $request, $id) {
        $setor = Setor::find($id);
       
        if($setor->filhos->count() == 0 )
        {
            $setor->delete();
            if($request->is(`api/setores/deletar/${id}`)){
                return response()->json(['sucesso' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('setores')->with('success', 'Deletado com sucesso!');
            }
        }else {
            if($request->is(`api/setores/deletar/${id}`)){
                return response()->json(['error' => 'Não é possível deletar!'], 404);
            }else{
                return redirect('setores')->with('danger', 'Não é possível deletar!');
            }
        }

    }
}


