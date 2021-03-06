<?php

namespace App\Http\Controllers;

use App\ActionDocumentUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionDocumentUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Action Document User Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the action document user' resources. That 
    | includes listening, showing, storing, creating and updating
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
     * @param  \App\ActionDocumentUser  $actionDocumentUser
     * @return \Illuminate\Http\Response
     */
    public function show(ActionDocumentUser $actionDocumentUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActionDocumentUser  $actionDocumentUser
     * @return \Illuminate\Http\Response
     */
    public function edit(ActionDocumentUser $actionDocumentUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActionDocumentUser  $actionDocumentUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActionDocumentUser $actionDocumentUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActionDocumentUser  $actionDocumentUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActionDocumentUser $actionDocumentUser)
    {
        //
    }
}
