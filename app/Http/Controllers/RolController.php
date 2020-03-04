<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Permiso;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $rols = Rol::all();
        $rols = Rol::with('permisos')->get();
        $permisos = Permiso::all();
        return view('rols.index', compact('rols', 'permisos'));
    }

    public  function refresh(){
        $rols = Rol::with('permisos')->get();
        $permisos = Permiso::all();
        return view('rols.table', compact('rols','permisos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rols.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // echo  response()->json($request->all());
       // $datos = $request->all();
        
        $datos = $request->except('_token');
        Rol::insert($datos);
        return RolController::Refresh();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Rol::findOrFail($id); //regresa toda la info que tiene ese id
        return view('rols.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dato = request()->except(['_token', '_method']);
        $id = $dato['id'];
        Rol::where('id', '=', $id)->update($dato);
        return RolController::Refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rol::destroy($id);
        return RolController::refresh();
    }
}
