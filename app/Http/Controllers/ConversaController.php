<?php

namespace App\Http\Controllers;

use App\Models\Conversa;
use App\Models\Mensagem;
use Illuminate\Http\Request;

class ConversaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Conversa::where(function ($query) {
            $query->where('usuario1_id', auth()->id())->whereOr('usuario2_id', auth()->id());
        })->orderBy('ultima_mensagem_at', 'DESC');
        return \response()->json($list->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $conversa_id = Conversa::where('usuario1_id', auth()->id())->where('usuario2_id', $request->get('usuario_id'))->first()->conversa_id ?? false;

        if (!$conversa_id) {
            $conversa_id = Conversa::where('usuario2_id', auth()->id())->where('usuario1_id', $request->get('usuario_id'))->first()->conversa_id ?? false;
        }

        if (!$conversa_id) {
            $conversa = new Conversa();
            $conversa->usuario1_id = auth()->id();
            $conversa->usuario2_id = $request->get('usuario_id');
            $conversa->ultima_mensagem_at = now()->toDateTimeString();
            $conversa->save();
            $conversa_id = $conversa->conversa_id;
        }

        $conversa = Conversa::find($conversa_id);

        $new = new Mensagem();
        $new->conversa_id = $conversa_id;
        $new->usuario_id = auth()->id();
        $new->mensagem = $request->get('mensagem');
        $new->lido_at = '';
        $new->save();

        $conversa->update(['ultima_mensagem_at' => now()->toDateTimeString()]);

        return \response()->json([$new]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $conversa_id)
    {

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

    public function mensagens($usuario_id, Request $request)
    {
        $conversa_id = Conversa::where('usuario1_id', auth()->id())->where('usuario2_id', $usuario_id)->first()->conversa_id ?? false;

        if (!$conversa_id) {
            $conversa_id = Conversa::where('usuario2_id', auth()->id())->where('usuario1_id', $usuario_id)->first()->conversa_id ?? false;
        }

        if ($conversa_id) {
            $list = Mensagem::where('conversa_id',$conversa_id);

            if ($request->get('ultimaMensagemId')) {
                $list->where('mensagem_id', '>', $request->get('ultimaMensagemId'));
            }

            $list->orderBY('mensagem_id', 'DESC');
            return \response()->json($list->paginate(15));
        }

        return \response()->json([]);
    }
}
