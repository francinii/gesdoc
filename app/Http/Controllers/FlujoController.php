<?php

namespace App\Http\Controllers;

use App\Flujo;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class FlujoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user()->id;
        $flujos =Flujo::where('userId', '=', $usuario)->get();
        //$flujos = Flujo::all();
        $users = User::all();
        return view('flujos.index',compact('flujos', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $request->except('_token', 'flujos');
       // $flujos = request('flujos');
        Flujo::insert($datos);
        return FlujoController::refresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function show(Flujo $flujo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function edit(Flujo $flujo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dato = request()->except(['_token', '_method', 'flujos']);
        $flujos = request('flujos');
        $id = $dato['id'];
        Flujo::where('id', '=', $id)->update($dato);
        
        return FlujoController::refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flujo  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Flujo::destroy($id);
        return FlujoController::refresh();
    }

    /**
     * Refresca la tabla que se muestra.
     *
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    private function refresh()
    {
        $flujos = Flujo::all();
        $users = User::all();
        return view('flujos.table',compact('flujos', 'users'));
    }
}
