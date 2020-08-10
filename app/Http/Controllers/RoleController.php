<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HomeTrait;
use App\Permission;
use App\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    use HomeTrait;
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
        $usuario = Auth::user()->username;
        $permissions = Auth::user()->role->permissions;
        $permissionsArray = $permissions->pluck('id')->toArray();

        if (in_array(1, $permissionsArray)) { // permission to see the department administration
            $roles = Role::all();
            $roles = Role::with('permissions')->get();
            $permissions = Permission::all();
            return view('roles.index', compact('roles', 'permissions'));
        }
        return $this->home();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool $create
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $create)
    {
        $validacion = [
            'description' => ['required', 'string', 'max:500'],
        ];
        if (!$create) {
            $validacion['id'] = ['required', 'int'];
        }

        return Validator::make($data, $validacion);
    }
    /**
     * transform a array to string
     * @param array $dato
     * @return String     
     */
    protected function myArray(array $dato)
    {
        $arryString = "'" . $dato['description'] . "'";
        $arryString .= ",'";
        $permissions = null;
        if (isset($dato['permissions'])) $permissions = $dato['permissions'];
        if ($permissions != null) {

            foreach ($permissions as $permission) {
                $arryString .= "$permission,";
            }
            $arryString = rtrim($arryString, ",");
        }
        $arryString .= "'";
        return $arryString;
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
     
        $this->validator($request->all(), true)->validate();
        $dato = $request->except('_token');
         $dato = $this->myArray($dato);
        if($dato != 1){  //If is differente than superAdmin
            DB::select("call insert_role($dato,@res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] == 3)  throw new DecryptException('el rol  ya existe en la base de datos');
            if ($res[0]['res'] != 0)  throw new DecryptException('error en la base de datos');
        }      
        return $this->refresh();
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
        if($id != 1){ //If is differente than superAdmin
            $roles = Role::findOrFail($id); //regresa toda la info que tiene ese id
            return view('roles.edit', compact('roles')); 
        }
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
        $this->validator($request->all(), false)->validate();
        $dato = request()->except(['_token', '_method']);
        $id = $dato['id'];
        $dato = $this->myArray($dato);
        if($id != 1){ //If is differente than superAdmin
            DB::select("call update_role($id,$dato,@res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] != 0)  throw new DecryptException('error en la base de datos'); 
        }
        return $this->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id != 1){ //If is differente than superAdmin
            DB::select("call delete_role($id,@res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] != 0)  throw new DecryptException('error en la base de datos'); 
        }
        return $this->refresh();
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
