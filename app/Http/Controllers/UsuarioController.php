<?php

namespace App\Http\Controllers;

use App\Models\Seguidor;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Usuario::where('usuario_id', '>=', 0);
        return \response()->json($list->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'sexo' => 'required|string',
            'telefone' => 'required|string',
            'data_nascimento' => 'required|string',
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $new = new Usuario();
        $new->nome = $request->get('nome');
        $new->email = $request->get('email');
        $new->telefone = $request->get('telefone');
        $new->bio = '';
        $new->foto_perfil_uri = '';
        $new->sexo = $request->get('sexo');
        $new->data_nascimento = $request->get('data_nascimento');
        $new->username = $request->get('username');
        $new->password = Hash::make($request->get('password'));
        $new->email_confirmado_at = '';
        $new->ultima_atividade_at = now()->toDateString();
        $new->save();

        return \response()->json($new);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $usuario)
    {
        $show = Usuario::where('username', $usuario);
        return \response()->json($show->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function seguir($usuario_id) {

        $seguindo = Seguidor::where('usuario1_id', auth()->id())
            ->where('usuario2_id', '=', $usuario_id)
            ->first();

        if (is_null($seguindo)) {
            $curtida = new Seguidor();
            $curtida->usuario1_id = auth()->id();
            $curtida->usuario2_id = $usuario_id;
            $curtida->save();

            Usuario::find($usuario_id)->increment('seguidores');
            Usuario::find(auth()->id())->increment('seguindo');

            $total_seguidores = Usuario::where('usuario_id', '=', $usuario_id)->first()->seguidores;
            return \response()->json(['acao' => 'seguir', 'seguidores' => $total_seguidores]);
        }

        $seguindo->delete();

        Usuario::find($usuario_id)->decrement('seguidores');
        Usuario::find(auth()->id())->decrement('seguindo');

        $total_seguidores = Usuario::where('usuario_id', '=', $usuario_id)->first()->seguidores;

        return \response()->json(['acao' => 'desseguir', 'seguidores' => $total_seguidores]);
    }

    public function alterarFotoPerfil(Request $request)
    {
        $uri = $request->get('uri') ?? '';
        $usuario = Usuario::find(auth()->id());
        $usuario->update([
            'foto_perfil_uri' => $uri
        ]);

        return \response()->json(['error' => true]);
    }
}
