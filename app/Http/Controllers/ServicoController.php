<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServicoRequest;
use App\Models\Servico;

class ServicoController extends Controller
{
    public $tipo_material = ['MR', 'MRC'];
    public $tipo_servico = ['Manutenção corretiva', 'Manutenção preventiva', 'Calibração', 'Qualificação', 'Auditoria', 'Consultoria', 'Manutenção predial', 'Terceirização'];

    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'servicos-'.$d.'.xls';
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
            $servico = Servico::where('descricao', 'like', "%".$pesquisa."%")
                                        ->orWhere('tipo_material', 'like', "%".$pesquisa."%")
                                        ->orWhere('tipo_servico', 'like', "%".$pesquisa."%")
                                        ->orWhere('servico_critico', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $servico = Servico::where('descricao', 'like', "%".$pesquisa."%")
                                        ->orWhere('tipo_material', 'like', "%".$pesquisa."%")
                                        ->orWhere('tipo_servico', 'like', "%".$pesquisa."%")
                                        ->orWhere('servico_critico', 'like', "%".$pesquisa."%")->all();
            return view('servicos.exportar', compact('servico'));
        } else if($tipo == 'exportar') {
            $servico = Servico::all();
            return view('servicos.exportar', compact('servico'));

        }else{
            $servico = Servico::paginate(10);
        }

            

        if($request->is('api/servicos')){
            return response()->json([$registro],200);
        }else{
            return view('servicos.index', compact('servico','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'servicos-'.$d.'.xls';
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
            $servico = Servico::where('descricao', 'like', "%".$pesquisa."%")
                                        ->orWhere('tipo_material', 'like', "%".$pesquisa."%")
                                        ->orWhere('tipo_servico', 'like', "%".$pesquisa."%")
                                        ->orWhere('servico_critico', 'like', "%".$pesquisa."%")->get();
        } else  {
            $servico = Servico::all();
        }
        
        return view('servicos.exportar', compact('servico'));
    } 
    public function novo() {
        $tipo_material = $this->tipo_material;
        $tipo_servico = $this->tipo_servico;
        
        return view('servicos.form', compact('tipo_material', 'tipo_servico'));
    }
    public function salvar(ServicoRequest $request) {

        $ehValido = $request->validated();
        $message = '';

        if($request->id == '') {
            $servico = Servico::create($request->all());
            $message = 'Salvo com sucesso';
        } else {
            $message = 'Alterado com sucesso'; 
            $servico = Servico::find($request->id);
            $servico->update($request->all());
        }
        if($request->is('api/servicos/salvar')){
            return response()->json(['success' => 'Salvo com sucesso!'],200);
        }else{
            return redirect('servicos/editar/' . $servico->id)->with('success', $message);
        }
    } 
    public function editar($id) {
        $servico = Servico::find($id);
        $tipo_material = $this->tipo_material;
        $tipo_servico = $this->tipo_servico;
        
        return view('servicos.form', compact('servico','tipo_material', 'tipo_servico'));
    }
    public function deletar(Request $request, $id) {
        $servico = Servico::find($id);
        if(!empty($servico)){
            $servico->delete();
            if($request->is(`api/servicos/deletar/${id}`)){
                return response()->json(['success' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('servicos')->with('success', 'Deletado com sucesso!');
            }
        } else {
            if($request->is(`api/servicos/deletar/${id}`)){
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }else{
                return redirect('servicos')->with('danger', 'Registro não encontrado!');
            }
        }
    }
}
