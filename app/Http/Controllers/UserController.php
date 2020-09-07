<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Department;
use App\Http\Controllers\Traits\HomeTrait;
use App\Role;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notification;

class UserController extends Controller
{
    use HomeTrait;
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the users' resources. That 
    | includes listening, showing, storing, creating and updating the users
    | in the system.
    |
    */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = Auth::user()->username;
        $permissions = Auth::user()->role->permissions;
        $permissionsArray = $permissions->pluck('id')->toArray();

        if(in_array(2, $permissionsArray)){ // permission to see the user managment
            $users = User::all();
            $roles = Role::all();
            $departments = Department::all();
            $notifications = Notification::where('username', '=', $username)->get();
            return view('users.index', compact('users', 'roles', 'departments','notifications')); 
        }
        return $this->home();
    }
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool $updatePassword
     * @param bool $create
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $updatePassword,$create)
    {
        $validacion = [
            'name' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'max:500'],
            'role_id'=> ['required', 'int'],
            'department_id'=> ['required', 'int'],

        ];
        if($create && env("use_LDAP")){
            $validacion['username']=['required', 'string', 'max:500', 'unique:users'];
        }
        elseif($create && !env("use_LDAP")){
            $validacion['username']=['required', 'string', 'max:500', 'unique:users'];
            $validacion['password']=['required', 'string', 'min:8'];
        }
        elseif(env("use_LDAP")||!$updatePassword){
            $validacion['username']=['required', 'string', 'max:500'];            
        }
        else{
            $validacion['username']=['required', 'string', 'max:500'];
            $validacion['password']=['required', 'string', 'min:8'];
        }

        return Validator::make($data, $validacion);
    }


    /**
     * transform a array to string
     * @param array $dato
     * @param boolean $create
     * @return String     
     */  
    protected function myArray(array $dato,$create)
    { 
        $arryString=$dato['role_id'].",".$dato['department_id'].",'".$dato['name']."','".$dato['username'].
        "','".$dato['email']."','".$dato['password']."'";
        if($create){
        $arryString.=",'".  Hash::make($dato['username'])."'";
        $arryString.=",'". __('app.home.table.defaultClassification')."'";
        $arryString.=",'". __('app.home.table.defaultShareClassification')."'";
        }else{
        $arryString.=",".$dato['updatePassword'];
        }
        
        return $arryString;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
  

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all(),false,true)->validate();
        $dato= $request->all();
        if (!env("use_LDAP")) {
            $dato = request()->except(['_token', '_method','updatePassword']);
            $dato['password'] = Hash::make($dato['password']);
        } else {
            $dato = request()->except(['_token', '_method','updatePassword', 'password']);
            $dato['password']="created with ldap";
        }
        $dato=$this->myArray($dato,true);  
        DB::select("call insert_user($dato,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']==3)  throw new DecryptException('el usuario ya existe en la base de datos');
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $updatePassword = filter_var(request('updatePassword'), FILTER_VALIDATE_BOOLEAN);
        $this->validator($request->all(), $updatePassword,false)->validate();
        $dato = request()->except(['_token', '_method']);
        if (!env("use_LDAP") && $updatePassword) {
            
            $dato['password'] = Hash::make($dato['password']);
        } 
       
        $dato=$this->myArray($dato,false);  
        DB::select("call update_user($dato,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']==3)  throw new DecryptException('el usuario ya existe en la base de datos');
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select("call delete_user('$id',@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
    }

    /**
     * Get the name of user in the ldap.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function ldapGetUser(Request $request)
    {
        if(!env("use_LDAP")){
            return response()->json(['encontrado'=>false]);
        }
         $connectionName = 'my-connection';
         $config = [
            // Mandatory Configuration Options
            'hosts'            => ['10.0.2.53'],
            'base_dn'          => 'dc=una,dc=ac,dc=cr',
            'username'         => '',
            'password'         => '',
    
            // Optional Configuration Options
            'schema'           =>  \Adldap\Schemas\ActiveDirectory::class,
            'account_prefix'   => '',
            'account_suffix'   => '',
            'port'             => 389,
            'follow_referrals' => false,
            'use_ssl'          => false,
            'use_tls'          => false,
            'version'          => 3,
            'timeout'          => 5,
    
            // Custom LDAP Options
            'custom_options'   => [
                // See: http://php.net/ldap_set_option
                LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD
            ]
        ];
        $ad = new \Adldap\Adldap();    
        
           

        $ad->addProvider($config, $connectionName);
        $datos = $request->all();
        $username = $datos['username'];
        $checkdn='uid='.$username.', ou=People, dc=una,dc=ac,dc=cr';
        //uid=402340420, ou=People, dc=una,dc=ac,dc=cr;
        try {
            $provider = $ad->connect($connectionName);
            $search = $provider->search();
            $result = $search->where('uid', '=',$username )->get();
            $user = $result[0];
           // $uid =  $user->getAttribute('uid')[0];
            $cn = $user->getAttribute('cn')[0];
            $mail = $user->getAttribute('mail')[0];
            
        } catch (Adldap\Auth\BindException $e) {
            return response()->json(['encontrado'=>false]);
        }
        return response()->json(['encontrado'=>true,'cn'=>$cn,'mail'=>$mail]);
    }
    

    /**
     * Refresh the table on the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $username = Auth::user()->username;
        $roles = Role::all();
        $users = User::all();
        $departments = Department::all();
        $notifications = Notification::where('username', '=', $username)->get();
        return view('users.table', compact('users', 'roles', 'departments','notifications'));
    }

    public function profile(){

        $username = Auth::id();
        $user=User::where('username', '=', $username)->get()[0];
        $departments = Department::all();
        $notifications = Notification::where('username', '=', $user->username)->get();
        $roles = Role::all();
        return view('users.profile', compact('user','notifications','roles','departments'));
    }


}
