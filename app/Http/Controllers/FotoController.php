<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\FotoLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list = Foto::where('usuario_id', $request->get('usuario_id'));
        return \response()->json($list->orderBy('created_at', 'DESC')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $total_fotos = Foto::where('usuario_id', auth()->id())->count();

        if ($total_fotos >= 2) {
            return \response()->json(['error' => true, 'message' => 'Limite de fotos atingido!']);
        }

        $new = new Foto();
        $new->usuario_id = auth()->id();
        $new->uri = $request->get('uri');
        $new->descricao = '';
        $new->save();

        return \response()->json([$new]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Foto::find($id);
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
    public function destroy(string $foto_id)
    {
        $usuario_id = auth()->id();

        $delete = Foto::where("foto_id", $foto_id)->where('usuario_id',$usuario_id);
        if ($delete) {
            FotoLike::where("foto_id", $foto_id)->delete();
            $delete->delete();
        }

        return \response()->json(['error' => true]);
    }

    public function curtir($foto_id) {
        $usuario_id = auth()->id();

        $curtir = FotoLike::where('foto_id', '=', $foto_id)
            ->where('usuario_id', '=', $usuario_id)
            ->first();

        if (is_null($curtir)) {
            $curtida = new FotoLike();
            $curtida->foto_id = $foto_id;
            $curtida->usuario_id = $usuario_id;
            $curtida->save();

            Foto::find($foto_id)->increment('curtidas');

            $total_curtidas = Foto::find($foto_id)->curtidas;

            return \response()->json(['curtir' => "true", 'total_curtidas' => $total_curtidas]);
        }

        $curtir->delete();

        Foto::find($foto_id)->decrement('curtidas');

        $total_curtidas = Foto::find($foto_id)->curtidas;

        return \response()->json(['curtir' => "false", 'total_curtidas' => $total_curtidas]);
    }
}
