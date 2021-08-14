<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspecao_recebidos;
use App\Models\Perguntas_lista_inspecao;
use App\Models\Respostas_lista_inspecao;
use App\Models\Fornecedor;
use App\Models\Equipamentos;
use App\Http\Requests\Inspecao_recebidosRequest;


class InspecaoRecebidosController extends Controller
{
    public function index(Request $request) {

        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'inspecao_recebidos-'.$d.'.xls';
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
            $inspecao_recebidos = Inspecao_recebidos::where('produto', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $inspecao_recebidos = Inspecao_recebidos::where('produto', 'like', "%".$pesquisa."%")->all();
            return view('inspecao_recebidos.exportar', compact('inspecao_recebidos'));
        } else if($tipo == 'exportar') {
            $inspecao_recebidos = Inspecao_recebidos::all();
            return view('inspecao_recebidos.exportar', compact('inspecao_recebidos'));

        }else{
            $inspecao_recebidos = Inspecao_recebidos::paginate(10);
        }



        if($request->is('api/inspecao_recebidos')){
            return response()->json([$inspecao_recebidos],200);
        }else{
            return view('inspecao_recebidos.index', compact('inspecao_recebidos','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'inspecao_recebidos-'.$d.'.xls';
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
            $inspecao_recebidos = Inspecao_recebidos::where('produto', 'like', "%".$pesquisa."%")->get();
        } else  {
            $inspecao_recebidos = Inspecao_recebidos::all();
        }
        return view('inspecao_recebidos.exportar', compact('inspecao_recebidos'));
    } 

    public function novo() {
        $pergunta = Perguntas_lista_inspecao::get();
        $produto = Equipamentos::with('fornecedor')->get();
        return view('inspecao_recebidos.form', compact('pergunta','produto'));
    }
    public function editar($id) {
        $pergunta = Perguntas_lista_inspecao::get();
        $inspecao_recebidos = Inspecao_recebidos::find($id);
        $resposta = Respostas_lista_inspecao::select('pergunta_id','resposta')->get();
        $produto = Equipamentos::with('fornecedor')->get();
        return view('inspecao_recebidos.form', compact('inspecao_recebidos','pergunta','produto','resposta'));
    }
    public function salvar(Inspecao_recebidosRequest $request) {
        $ehvalido = $request->validated();
        
        if($request->id != '') {
            $inspecao_recebidos = Inspecao_recebidos::find($request->id);
            $resposta_lista_inspecao = Respostas_lista_inspecao::find($request->id);

            $campos_inspecao = [
                'produto_id' => $request->produto_id,
                'fornecedor' => $request->fornecedor,
                'fabricante' => $request->fabricante,
                'nota_fiscal' => $request->nota_fiscal,
                'lote' => $request->lote, 
                'descricao_teste' => $request->descricao_teste,
                'insumo_liberado' => $request->insumo_liberado,
                'justificativa' => $request->justificativa
            ];
            $inspecao_recebidos->update($campos_inspecao);

            foreach ($request->resposta as $key => $value) {
                $respostas['inspecao_id'] = $resposta_lista_inspecao->id;
                $respostas['pergunta_id'] = $key;
                $respostas['resposta'] = $value;
                $resposta_lista_inspecao->update($respostas);
            }
        } else {
            $campos_inspecao = [
                'produto_id' => $request->produto_id,
                'fornecedor' => $request->fornecedor,
                'fabricante' => $request->fabricante,
                'nota_fiscal' => $request->nota_fiscal,
                'lote' => $request->lote, 
                'descricao_teste' => $request->descricao_teste,
                'insumo_liberado' => $request->insumo_liberado,
                'justificativa' => $request->justificativa
            ];
            $inspecao_recebidos = Inspecao_recebidos::create($campos_inspecao);
            foreach ($request->resposta as $key => $value) {
                $respostas['inspecao_id'] = $inspecao_recebidos->id;
                $respostas['pergunta_id'] = $key;
                $respostas['resposta'] = $value;
                $resposta_lista_inspecao = Respostas_lista_inspecao::create($respostas);
            }
        }
        return redirect('/inspecao_recebidos/editar/'. $inspecao_recebidos->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $inspecao_recebidos = Inspecao_recebidos::find($id);
        if(!empty($inspecao_recebidos)){
            $inspecao_recebidos->delete();
            return redirect('inspecao_recebidos')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('inspecao_recebidos')->with('danger', 'Registro não encontrado!');
        }
    }
}
