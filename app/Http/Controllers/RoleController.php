<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Role Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the roles' resources. That
    | includes listening, showing, storing, creating and updating the system's
    | roles.
    |
     */

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
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validacion = [
            'description' => ['required', 'string', 'max:255'],
        ];

        return Validator::make($data, $validacion);
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
        $this->validator($request->all())->validate();
        $datos = $request->except('_token', 'permissions');

        $permissions = request('permissions');
        $IdRole = Role::insertGetId($datos);
        if ($permissions != null) {
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
        $this->validator($request->all())->validate();
        $dato = request()->except(['_token', '_method', 'permissions']);
        $permissions = request('permissions');
        $id = $dato['id'];
        Role::where('id', '=', $id)->update($dato);
        DB::table('permission_role')->where('role_id', '=', $id)->delete();
        if ($permissions != null) {
            foreach ($permissions as $permission) {
                DB::table('permission_role')->insert([
                    'role_id' => $id,
                    'permission_id' => $permission,
                ]);
            }
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
     * Refresh the table on the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('roles.table', compact('roles', 'permissions'));
    }
}
