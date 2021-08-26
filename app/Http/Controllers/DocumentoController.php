<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Setor;

use PDF;

class DocumentoController extends Controller
{
    public $tipo = ['Manual','Procedimento','Anexo','Instrução de uso/trabalho','Formulário'];
    public function index(Request $request) {
        $pesquisa = $request->pesquisa;
        $tipo = $request->tipo;

        if($tipo == 'exportar') {
            $d = date('d-m-Y-H-m-s');
            $arquivo = 'documento-'.$d.'.xls';
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
            $documento = Documento::where('nome', 'like', "%".$pesquisa."%")->paginate(1000);
        } else if($pesquisa != '' && $tipo == 'exportar') {
            $documento = Documento::where('nome', 'like', "%".$pesquisa."%")->all();
            return view('documento.exportar', compact('documento'));
        } else if($tipo == 'exportar') {
            $documento = Documento::all();
            return view('documento.exportar', compact('documento'));

        }else{
            $documento = Documento::paginate(10);
        }



        if($request->is('api/documento')){
            return response()->json([$documento],200);
        }else{
            return view('documento.index', compact('documento','pesquisa'));
        }
    } 
    public function exportar(Request $request) {
        $pesquisa = $request->pesquisa;
         
        $d = date('d-m-Y-H-m-s');
        $arquivo = 'documento-'.$d.'.xls';
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
            $documento = Documento::where('nome', 'like', "%".$pesquisa."%")->get();
        } else  {
            $documento = Documento::all();
        }
        return view('documento.exportar', compact('documento'));
    } 
    public function exportar_pdf(Request $request) {
        $pesquisa = $request->pesquisa;
        
        if($pesquisa != '') {
            $documento = Documento::where('nome', 'like', "%".$pesquisa."%")->get();
        } else  {
            $documento = Documento::all();
        }
        
        view()->share('documento', $documento);
        
        // para visualizar antes
        //return view('documento.exportar_pdf', compact('documento'));
        
        $pdf_doc = PDF::loadView('documento.exportar_pdf', $documento);
        //para paisagem
        //$pdf_doc->setPaper('a4', 'landscape'); 
       
        //para download direto
        //return $pdf_doc->download('documento.pdf');
        return $pdf_doc->stream('documento.pdf');
    } 
    public function exportar_pdf_documentos(Request $request) {
        $pesquisa = $request->pesquisa;
        
        if($pesquisa != '') {
            $documento = Documento::where('nome', 'like', "%".$pesquisa."%")->get();
        } else  {
            $documento = Documento::all();
        }
        
        view()->share('documento', $documento);
        
        // para visualizar antes
        //return view('documento.exportar_pdf', compact('documento'));
        
        $pdf_doc = PDF::loadView('documento.exportar_pdf', $documento);
        //para paisagem
        //$pdf_doc->setPaper('a4', 'landscape'); 
       
        //para download direto
        //return $pdf_doc->download('documento.pdf');
        return $pdf_doc->stream('documento.pdf');
    } 
    public function novo(Request $request) { 
    
        $setores = Setor::select('id','setor')->get();
        $tipo = $this->tipo;
        if($request->is(`api/documentos/novo`)){
            return response()->json([$setores], 200);
        }else{
            return view('documento/form', compact('setores', 'tipo'));
        }

    }
    public function editar($id) {
        $tipo = ['Manual','Procedimento','Anexo','Instrução de uso/trabalho','Formulário'];
        $setores = Setor::select('id','setor')->get();
        $documento = Documento::find($id);
        $tipo = $this->tipo;
        return view('documento/form', compact('documento', 'setores', 'tipo'));
    }
    public function salvar(Request $request) {
 
        if($request->hasFile('documento_temp')) {
            // renomeando documento 
            $nome_documento = date('YmdHmi').'.'.$request->documento_temp->getClientOriginalExtension();
            $request['documento'] = '/uploads/documento/' . $nome_documento;
            ($request->documento);
            $request->documento_temp->move(public_path('uploads/documento'), $nome_documento);
        }

        if($request->id != '') {
            $documento = Documento::find($request->id);
                $documento->update($request->all());
        } else {
            $documento = Documento::create($request->all());
        }
        if($request->is(`api/documentos/salvar`)){
            return response()->json(['success' => 'Deletado com sucesso!'], 200);
        }else{
            return redirect('/documento/editar/'. $documento->id)->with('success', 'Salvo com sucesso!');
        }
    }
 
    public function deletar(Request $request, $id) {
        $documento = Documento::find($id);
        if(!empty($documento)){
            $documento->delete();
            if($request->is(`api/documentos/deletar/${id}`)){
                return response()->json(['success' => 'Deletado com sucesso!'], 200);
            }else{
                return redirect('documento')->with('success', 'Deletado com sucesso!');
            }
        } else {
            if($request->is(`api/documentos/deletar/${id}`)){
                return response()->json(['error' => 'Registro não encontrado!'], 404);
            }else{
                return redirect('documento')->with('danger', 'Registro não encontrado!');
            }
        }
    }
    // public $tipos = ['Manual','Procedimento','Anexo','Instrução de uso/trabalho','Formulário'];

    // public function index(Request $request) {
    //     $pesquisa = $request->pesquisa;

    //     if($pesquisa != '') {
    //         $documento = Documentos_internos::where('nome', 'like', "%".$pesquisa."%")->paginate(1000);
    //     } else {
    //         $documento = Documentos_internos::paginate(10);
    //     }
    //     return view('documento\index', compact('documento'));
    // } 
    // public function novo() {
    //     $tipos = $this->tipos;
    //     return view('documento\form', compact('tipos'));
    // }
    // public function editar($id) {
    //     $tipos = $this->tipos;
    //     $documento = Documento::find($id);
    //     return view('documento\form', compact('documento', 'tipos'));
    // }
    // public function salvar(Request $request) {
    //    // dd($request->all());

    //     if($request->hasFile('documento_temp')) {
    //         echo 'tem documento';
    //         // renomeando documento 
    //         $nome_documento = date('YmdHmi').'.'.$request->documento_temp->getClientOriginalExtension();

    //         $request['documento'] = '/uploads/documento/' . $nome_documento;

    //         $request->documento_temp->move(public_path('uploads/documento'), $nome_documento);
    //     }

    //     if($request->id != '') {
    //         $documento = Documento::find($request->id);
    //         $documento->update($request->all());
    //     } else {
    //         $documento = Documento::create($request->all());
    //     }
    //     return redirect('/documento/editar/'. $documento->id)->with('success', 'Salvo com sucesso!');
    // }

    // public function deletar($id) {
    //     $documento = Documento::find($id);
    //     if(!empty($documento)){
    //         $documento->delete();
    //         return redirect('documento')->with('success', 'Deletado com sucesso!');
    //     } else {
    //         return redirect('documento')->with('danger', 'Registro não encontrado!');
    //     }
    // }
}

