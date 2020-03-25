<?php

namespace App\Http\Controllers;

use App\Flow;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class FlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user()->id;
        $flows =Flow::where('user_id', '=', $usuario)->get();
        //$Flows = Flow::all();
        $users = User::all();
        return view('Flows.index',compact('flows', 'users'));
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
        $datos = $request->except('_token', 'flows');
       // $flows = request('flows');
        Flow::insert($datos);
        return FlowController::refresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function show(Flow $flow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function edit(Flow $flow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dato = request()->except(['_token', '_method', 'flows']);
        $flows = request('flows');
        $id = $dato['id'];
        Flow::where('id', '=', $id)->update($dato);
        
        return FlowController::refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flow  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Flow::destroy($id);
        return FlowController::refresh();
    }

    /**
     * Refresca la tabla que se muestra.
     *
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    private function refresh()
    {
        $usuario = Auth::user()->id;
        $flows =Flow::where('user_id', '=', $usuario)->get();
        //$flows = Flow::all();
        $users = User::all();
        return view('flows.table',compact('flows', 'users'));
    }
}
