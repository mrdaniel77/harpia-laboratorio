<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use APP\Models\User;

class UserController extends Controller
{
    public function index(Request $request) {
        $pesquisa = $request->pesquisa;

        if($pesquisa != '') {
            $users = User::where('nome', 'like', "%".$pesquisa."%")->paginate(1000);
        } else {
            $users = User::paginate(10);
        }
        return view('user.index', compact('users','pesquisa'));
    } 
    public function novo() {

        return view('user.form');
    }
    public function editar($id) {

        $user = User::find($id);
        return view('user.form', compact('user'));
    }
    public function salvar(UserRequest $request) {

        $ehvalido = $request->validated();
        if($request->id != '') {
            $user = User::find($request->id);
            $user->update($request->all());
        } else {
            $user = User::create($request->all());
        }
        return redirect('/user/editar/'. $user->id)->with('success', 'Salvo com sucesso!');
    }
    public function deletar($id) {
        $user = User::find($id);
        if(!empty($user)){
            $user->delete();
            return redirect('user')->with('success', 'Deletado com sucesso!');
        } else {
            return redirect('user')->with('danger', 'Registro não encontrado!');
        }
    }

}
