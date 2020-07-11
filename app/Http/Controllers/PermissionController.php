<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Permission Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the permission' resources. That 
    | includes listening, showing, storing, creating and updating the system' 
    | permissions.
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
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permiso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permiso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permiso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permiso)
    {
        //
    }
}
