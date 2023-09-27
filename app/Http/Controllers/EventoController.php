<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EventoPresenca;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = new Evento();
        return \response()->json($list->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = Evento::find($id);
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

    public function presenca($evento_id) {
        $usuario_id = auth()->id();

        $presenca = EventoPresenca::where('evento_id', '=', $evento_id)
            ->where('usuario_id', '=', $usuario_id)
            ->first();

        if (is_null($presenca)) {
            $nova_presenca = new EventoPresenca();
            $nova_presenca->evento_id = $evento_id;
            $nova_presenca->usuario_id = $usuario_id;
            $nova_presenca->save();

            Evento::find($evento_id)->increment('confirmados');

            $total_confirmados = Evento::find($evento_id)->confirmados;

            return \response()->json(['confirmado' => "true", 'total_confirmados' => $total_confirmados]);
        }

        $presenca->delete();

        Evento::find($evento_id)->decrement('confirmados');

        $total_confirmados = Evento::find($evento_id)->confirmados;

        return \response()->json(['confirmado' => "false", 'total_confirmados' => $total_confirmados]);
    }
}
