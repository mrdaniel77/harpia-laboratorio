<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ParticipantesResquest;
use App\Models\ParticipantesTreinamento;
use App\Models\RegistroTreinamento;
use App\Models\Setor;
use App\Models\Colaborador;


class ParticipantesTreinamentoController extends Controller
{  

        public function index(Request $request) {
            $pesquisa = $request->pesquisa;
            $treinamento_id = $request->treinamento_id;
            $treinamento = RegistroTreinamento::find($treinamento_id);
            $tipo = $request->tipo;

            if($tipo == 'exportar') {
                $d = date('d-m-Y-H-m-s');
                $arquivo = 'participantes_treinamento-'.$d.'.xls';
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
                $participantes_treinamento = ParticipantesTreinamento::with('treinamento')->where('numero', 'like', "%".$pesquisa."%")
                                                                    ->where('registro_treinamento_id','=', $treinamento_id)
                                                                    ->orWhere('setor', 'like', "%".$pesquisa."%")
                                                                    ->orWhere('nome', 'like', "%".$pesquisa."%")->paginate(1000);
            } else if($pesquisa != '' && $tipo == 'exportar') {
                $participantes_treinamento = ParticipantesTreinamento::with('treinamento')->where('numero', 'like', "%".$pesquisa."%")
                                                                    ->where('registro_treinamento_id','=', $treinamento_id)
                                                                    ->orWhere('setor', 'like', "%".$pesquisa."%")
                                                                    ->orWhere('nome', 'like', "%".$pesquisa."%")->all();
                return view('participantes_treinamento.exportar', compact('participantes_treinamento'));
            } else if($tipo == 'exportar') {
                $participantes_treinamento = ParticipantesTreinamento::all();
                return view('participantes_treinamento.exportar', compact('participantes_treinamento'));
    
            }else{
                $participantes_treinamento = ParticipantesTreinamento::paginate(10);
            }
    
                
    
            if($request->is('api/participantes_treinamento')){
                return response()->json([$registro],200);
            }else{
                return view('participantes_treinamento.index', compact('participantes_treinamento','pesquisa'));
            }
        } 
        public function exportar(Request $request) {
            $pesquisa = $request->pesquisa;
             
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'participantes_treinamento-'.$d.'.xls';
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
                $participantes_treinamento = ParticipantesTreinamento::with('treinamento')->where('numero', 'like', "%".$pesquisa."%")
                                                                    ->where('registro_treinamento_id','=', $treinamento_id)
                                                                    ->orWhere('setor', 'like', "%".$pesquisa."%")
                                                                    ->orWhere('nome', 'like', "%".$pesquisa."%")->get();
            } else  {
                $participantes_treinamento = ParticipantesTreinamento::all();
            }
            
            return view('participantes_treinamento.exportar', compact('participantes_treinamento'));
        } 
        public function novo(Request $request) {

            $treinamento_id = $request->treinamento_id;
            if($treinamento_id != '') {
                $treinamento = RegistroTreinamento::find($treinamento_id);
            } else {
                $treinamento = '';
            }
            $setores = Setor::select('setor')->get();
            $colaboradores = Colaborador::select('nome')->get();

            $nome = ParticipantesTreinamento::select('nome')
            ->groupBy('nome')
            ->get();
        return view('participantes_treinamento.form', compact('setores','colaboradores', 'nome', 'treinamento'));
        }
        public function editar($id) {

            $setores = Setor::select('setor')->get();
            $colaboradores = Colaborador::select('nome')->get();

            $participantes_treinamento = ParticipantesTreinamento::find($id);
            $treinamento = RegistroTreinamento::find($participantes_treinamento->registro_treinamento_id);

            $nome = ParticipantesTreinamento::select('nome')
                                    ->groupBy('nome')
                                    ->get();

            return view('participantes_treinamento.form', compact('setores','colaboradores', 'participantes_treinamento', 'nome', 'treinamento'));
        }
        public function salvar(ParticipantesResquest $request) {

            $ehvalido = $request->validated();

            if($request->id != '') {
                $participantes_treinamento = ParticipantesTreinamento::find($request->id);
                $participantes_treinamento->update($request->all());
            } else {
                $participantes_treinamento = ParticipantesTreinamento::create($request->all());
            }
            return redirect('/participantes_treinamento/editar/'. $participantes_treinamento->id)->with('success', 'Salvo com sucesso!');
        }
        public function deletar($id) {
            $participantes_treinamento = ParticipantesTreinamento::find($id);
            if(!empty($participantes_treinamento)){
                $participantes_treinamento->delete();
                return redirect('participantes_treinamento')->with('success', 'Deletado com sucesso!');
            } else {
                return redirect('participantes_treinamento')->with('danger', 'Registro não encontrado!');
            }
    }
    public function list() {
        $participantes_treinamento = ParticipantesTreinamento::paginate();

        return response()->json($participantes_treinamento, 200);
    }
        
}

