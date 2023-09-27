<?php

namespace App\Http\Controllers;

use App\Models\LogAcesso;
use Illuminate\Http\Request;

class LogAcessoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = new LogAcesso();
        return \response()->json($list->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new = new LogAcesso();
        $new->usuario_id = $request->get('usuario_id');
        $new->ip = $request->ip();
        $new->save();

        return \response()->json($new);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $show = LogAcesso::find($id);
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
}
