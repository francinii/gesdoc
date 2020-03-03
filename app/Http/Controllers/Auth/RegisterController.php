<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Rol;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
          //  'rol' => ['required', 'integer', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'rol_id' => $data['rol'],
            'password' => Hash::make($data['password']),
        ]);
    }
        /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function ldapObtenerUsuario(Request $request)
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



    public function showRegistrationForm(){
        $rols = Rol::all();
        return view('auth.register', compact('rols'));
    }



}


