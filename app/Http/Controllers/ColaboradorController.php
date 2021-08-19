<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;
use App\Models\Setor;
use App\Http\Requests\ColaboradorRequest;

class ColaboradorController extends Controller
{
    public function index(Request $request){
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'colaboradores-'.$d.'.xls';
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
            $colaborador = Colaborador::where('nome', 'like', "%".$pesquisa."%")
                                ->orWhere('cpf', 'like', "%".$pesquisa."%")
                                ->orWhere('email', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $colaborador = Colaborador::where('nome', 'like', "%".$pesquisa."%")
                                ->orWhere('cpf', 'like', "%".$pesquisa."%")
                                ->orWhere('email', 'like', "%".$pesquisa."%")->all();
            return view('colaboradores.exportar', compact('colaborador'));
        } else if($tipo == 'exportar') {
            $colaborador = Colaborador::all();
            return view('colaboradores.exportar', compact('colaborador'));

        }else{
            $colaborador = Colaborador::paginate(10);
        }

            

        if($request->is('api/colaboradores')){
            return response()->json([$registro],200);
        }else{
            return view('colaboradores.index', compact('colaborador','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'colaboradores-'.$d.'.xls';
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
            $colaborador = Colaborador::where('colaborador', 'like', "%".$pesquisa."%")
                                ->orWhere('cpf', 'like', "%".$pesquisa."%")
                                ->orWhere('email', 'like', "%".$pesquisa."%")->get();
        } else  {
            $colaborador = Colaborador::all();
        }
        
        return view('colaboradores.exportar', compact('colaborador'));
    } 

    public function novo(Request $request){
        $setores = Setor::select('setor')->get();
        if($request->is('api/colaboradores/novo')){
            return response()->json([$setores],200);
        }else{
            return view('colaboradores.form', compact('setores'));
        }
    }

    public function editar($id){
        $setores = Setor::select('setor')->get();
        $colaborador = Colaborador::find($id);
        return view('colaboradores.form', compact('colaborador', 'setores'));
    }

    public function salvar(ColaboradorRequest $request){

        if($request->hasFile('foto')) {
             echo 'tem documento';
             // renomeando documento 
             $nome_documento = date('YmdHmi').'.'.$request->foto->getClientOriginalExtension();
 
             $request['user'] = '/uploads/usuario/' . $nome_documento;
 
             $request->foto->move(public_path('uploads/usuario'), $nome_documento);
         }
        
        $ehValido = $request->validated();

        if($request->id != ''){
            $colaborador = Colaborador::find($request->id);
            $colaborador->update($request->all());
        }else {
            $colaborador = Colaborador::create($request->all());
        }
        if($request->is('api/colaboradores/salvar')){
            return response()->json(['success' => 'Salvo com sucesso!'],200);
        }else{
            return redirect('/colaboradores/editar/'.$colaborador->id)->with('success', 'Salvo com sucesso!');
        }
    }

    public function deletar(Request $request, $id){
        $colaborador = Colaborador::find($id);
        if(!empty($colaborador)){
            $colaborador->delete();
            if($request->path == `api/colaboradores/deletar/${id}`){
                return response()->json(['success' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('colaboradores')->with('success', 'Deletado com sucesso!');
            }
        } else {
            if($request->path == `api/colaboradores/deletar/${id}`){
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }else{
                return redirect('colaboradores')->with('danger', 'Registro não encontrado!');
            }
        }
    }
}