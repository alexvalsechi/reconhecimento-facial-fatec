<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private $validacao = array(
        'nome' => 'required',
        'email' => 'required|unique:App\Models\User',
        'departamento' => 'required',
        'senha' => 'required',
        'foto' => 'required'

    );
    public function index(){
        return view('cadastro_pessoa');
    }

    public function salvar(Request $request){
        $request->validate($this->validacao,$request->post());
        try{
        $user = new \App\Models\User;
        $user->name = $request->input('nome');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('senha'));
        $user->empresa_id = 1;
        $user->departamento = $request->input('departamento');
        $arquivo_foto = file_get_contents($request->file('foto')->getRealPath());
        $user->arquivo_foto =$arquivo_foto;
        $user->mime_type_foto = mime_content_type($request->file('foto')->getRealPath());

        $user->saveOrFail();
        }catch(Exception $ex){

        }
        return redirect('/usuario');
    }
}
