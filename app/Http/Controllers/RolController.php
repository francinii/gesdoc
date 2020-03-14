<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permiso;
use App\Rol;
use DB;
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

    public function refresh()
    {
        $rols = Rol::with('permisos')->get();
        $permisos = Permiso::all();
        return view('rols.table', compact('rols', 'permisos'));
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

        $datos = $request->except('_token', 'permisos');
        $permisos = request('permisos');
        $Idrol = Rol::insertGetId($datos);
        foreach ($permisos as $permiso) {
            DB::table('permiso_rol')->insert([
                'rol_id' => $Idrol,
                'permiso_id' => $permiso,
            ]);
        }

        return RolController::refresh();

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
        $dato = request()->except(['_token', '_method', 'permisos']);
        $permisos = request('permisos');
        $id = $dato['id'];
        Rol::where('id', '=', $id)->update($dato);
        DB::table('permiso_rol')->where('rol_id', '=', $id)->delete();
        foreach ($permisos as $permiso) {
            DB::table('permiso_rol')->insert([
                'rol_id' => $id,
                'permiso_id' => $permiso,
            ]);
        }
        return RolController::refresh();
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
