<?php

namespace App\Http\Controllers;

use App\Models\Publicacao;
use App\Models\PublicacaoLike;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PublicacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list = Publicacao::where('publicacao_id', '>=', 0);

        if ($request->get('username')) {
            $usuario_id = Usuario::where('username', $request->get('username'))->first()->usuario_id;
            $list->where('usuario_id', '=', $usuario_id);
        }

        return \response()->json($list->orderBy('created_at', 'DESC')->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = new Publicacao();
        $new->usuario_id = auth()->id();
        $new->image = $request->get('uri') ?? '';
        $new->mensagem = $request->get('legenda') ?? '';
        $new->curtidas = 0;
        $new->save();

        return \response()->json([$new]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Publicacao::find($id);
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
    public function destroy(string $publicacao_id)
    {
        $usuario_id = auth()->id();

        $delete = Publicacao::where("publicacao_id", $publicacao_id)->where('usuario_id',$usuario_id);
        if ($delete) {
            PublicacaoLike::where("publicacao_id", $publicacao_id)->delete();
            $delete->delete();
        }

        return \response()->json(['error' => true]);
    }

    public function curtir($publicacao_id) {
        $usuario_id = auth()->id();

        $curtir = PublicacaoLike::where('publicacao_id', '=', $publicacao_id)
            ->where('usuario_id', '=', $usuario_id)
            ->first();

        if (is_null($curtir)) {
            $curtida = new PublicacaoLike();
            $curtida->publicacao_id = $publicacao_id;
            $curtida->usuario_id = $usuario_id;
            $curtida->save();

            Publicacao::find($publicacao_id)->increment('curtidas');

            $total_curtidas = Publicacao::find($publicacao_id)->curtidas;

            return \response()->json(['curtir' => "true", 'total_curtidas' => $total_curtidas]);
        }

        $curtir->delete();

        Publicacao::find($publicacao_id)->decrement('curtidas');

        $total_curtidas = Publicacao::find($publicacao_id)->curtidas;

        return \response()->json(['curtir' => "false", 'total_curtidas' => $total_curtidas]);
    }
}
