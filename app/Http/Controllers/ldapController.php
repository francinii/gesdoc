<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Adldap\AdldapInterface;

class ldapController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ldapObtenerUsuario(Request $request)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
