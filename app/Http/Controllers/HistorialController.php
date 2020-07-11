<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Historial;
use DB; 

class HistorialController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Historial Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the historial' resources. That 
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
        $historial = Historial::all();
        return view('historial.index', compact('historial'));
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
     * @param  \App\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function show(Historial $historial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function edit(Historial $historial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historial $historial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historial $historial)
    {
        
    }
}
