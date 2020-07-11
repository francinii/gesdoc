<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Flow;
use App\User;
use App\Department;
use App\Document;
use App\Version;
use App\Action;
use App\Note;
use App\Historial;
use App\ViewFlowUser;
use App\ActionStepUser;
use App\StepStep;
use App\ViewActionStepStepUser;
use DB;
use Auth;

class UserDocFlowController extends Controller
{

/*
    |--------------------------------------------------------------------------
    | UserDocFlow Controller
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
        $usuario = Auth::user()->username;        
        $users = User::all();        
        $actions = Action::all();
        $flow = '';
        $flows =ViewFlowUser::where('username', '=', $usuario)->get();
        if($flows->isNotEmpty()){
            $flow = $flows->first()->flow_id;
        }
       
        $documents = Document::where('flow_id', '=', $flow)->get();
        return view('userDocFlow.index',compact('flow','flows', 'users','documents','actions'));
  
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
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $datos = request()->except(['_token']);
        $flow = $datos['idFlow'];
        return $this->refresh($flow);
        
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentFlow $documentFlow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentFlow $documentFlow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentFlow $documentFlow)
    {
        //
    }


    public function refresh($flow) {
        $usuario = Auth::user()->username;
        
        //$Flows = Flow::all();
        $users = User::all();
       
        $actions = Action::all();
       // $flowsUser = ViewFlowUser::all();
        $flows =ViewFlowUser::where('username', '=', $usuario)
        ->get();
        //$flow = $flows->first()->flow_id;
        $documents = Document::where('flow_id', '=', $flow)->get();
        return view('userDocFlow.table',compact('flow','flows', 'users','documents','actions'));
    }

}
