<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Flow;
use App\User;
//use App\Department;
use App\Document;
use App\Version;
use App\Action;
//use App\Note;
//use App\Historial;
use App\ViewFlowUser;
use App\ActionStepUser;
use App\Http\Controllers\Traits\HomeTrait;
//use App\StepStep;
//use App\ViewActionStepStepUser;
//use DB;
use Illuminate\Support\Facades\Auth;

class UserDocFlowController extends Controller
{
    use HomeTrait;

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
        $permissions = Auth::user()->role->permissions;
        $permissionsArray = $permissions->pluck('id')->toArray();

        if (in_array(6, $permissionsArray)) { // permission to see the documento Flow screen    
            $usuario = Auth::user()->username;
            $users = User::all();
            $actions = Action::all();
            $flow = '';
            $flows = ViewFlowUser::where('username', '=', $usuario)->get();
            if ($flows->isNotEmpty()) {
                $flow = $flows->first()->flow_id;
            }
            $docs = Document::where('flow_id', '=', $flow)->get();
            $documents = array();
            foreach ($docs as $doc) {
                $version = Version::where('document_id', '=', $doc->id)->orderBy('version', 'DESC')->first();
                $flow = $version->flow_id;
                $drag = $version->identifier;
                $asu = ActionStepUser::where('step_id', '=', $drag)->where('flow_id', '=', $flow)
                    ->where('username', '=', $usuario)->first();
                if ($asu != NULL) {
                    array_push($documents, $doc);
                }
            }
            return view('userDocFlow.index', compact('flow', 'flows', 'users', 'documents', 'actions'));
        }
        return $this->home();
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


    public function refresh($flow)
    {
        $usuario = Auth::user()->username;
        $users = User::all();
        $actions = Action::all();
        $flows = ViewFlowUser::where('username', '=', $usuario)->get();
        $docs = Document::where('flow_id', '=', $flow)->get();
        $documents = array();
        foreach ($docs as $doc) {
            $version = Version::where('document_id', '=', $doc->id)->orderBy('version', 'DESC')->first();
            $flow = $version->flow_id;
            $drag = $version->identifier;
            $asu = ActionStepUser::where('step_id', '=', $drag)->where('flow_id', '=', $flow)
                ->where('username', '=', $usuario)->first();
            if ($asu != NULL) {
                array_push($documents, $doc);
            }
        }

        //1.  obtener la ultima version de cada documento de 
        // De la version ocupo el flujo el drag asociado
        // Con el flujo y drag de esa ultima version consutlo en la tabla action step user si 
        // con el flujo y el drag si me regresa cero no tengo ningun permiso para ver el doc

        return view('userDocFlow.table', compact('flow', 'flows', 'users', 'documents', 'actions'));
    }
}
