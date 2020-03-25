<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use DB;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        // $roles = Role::all();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo  response()->json($request->all());
        // $datos = $request->all();

        $datos = $request->except('_token', 'permissions');
        
        $permissions = request('permissions');
        $IdRole = Role::insertGetId($datos);
        if($permissions != NULL){
            foreach ($permissions as $permission) {
                DB::table('permission_role')->insert([
                    'role_id' => $IdRole,
                    'permission_id' => $permission,
                ]);
            }
        }

        return RoleController::refresh();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::findOrFail($id); //regresa toda la info que tiene ese id
        return view('roles.edit', compact('roles'));
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
        $dato = request()->except(['_token', '_method', 'permissions']);
        $permissions = request('permissions');
        $id = $dato['id'];
        Role::where('id', '=', $id)->update($dato);
        DB::table('permission_role')->where('role_id', '=', $id)->delete();
        foreach ($permissions as $permission) {
            DB::table('permission_role')->insert([
                'role_id' => $id,
                'permission_id' => $permission,
            ]);
        }
        return RoleController::refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return RoleController::refresh();
    }


    /**
     * Refresca la tabla que se muestra.
     *
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('roles.table', compact('roles', 'permissions'));
    }
}
