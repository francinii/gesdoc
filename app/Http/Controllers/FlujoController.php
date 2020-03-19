<?php

namespace App\Http\Controllers;

use App\Flujo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlujoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flujos = Flujo::all();
        return view('flujos.index',compact('flujos'));
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
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function show(Flujo $flujo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function edit(Flujo $flujo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flujo $flujo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flujo  $flujo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flujo $flujo)
    {
        //
    }
}
