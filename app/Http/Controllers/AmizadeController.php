<?php

namespace App\Http\Controllers;

use App\Models\Seguidor;
use Illuminate\Http\Request;

class AmizadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = new Seguidor();
        return \response()->json($list->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = new Seguidor();
        $new->usuario_id = $request->get('usuario_id');
        $new->usuario_amigo_id = $request->get('usuario_amigo_id');
        $new->status = 'P';
        $new->save();

        return \response()->json($new);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
