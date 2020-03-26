<?php

namespace App\Http\Controllers;

use App\DocumentUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Document User Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the document users' resources. That 
    | includes listening, showing, storing, creating and updating
    |
    */

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
     * @param  \App\DocumentUser  $documentUser
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentUser $documentUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentUser  $documentUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentUser $documentUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentUser  $documentUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentUser $documentUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentUser  $documentUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentUser $documentUser)
    {
        //
    }
}
