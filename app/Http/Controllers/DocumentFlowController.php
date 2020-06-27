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
use DB;
use Auth;

class DocumentFlowController extends Controller
{
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
      // $document = Document::find(1);
      // $documents = $document->state;
      //  $states = $documents->state;

        return view('documentFlow.index',compact('flow','flows', 'users','documents','actions'));
  
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
     * Display the specified historial of a resource.
     *
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function historial(Request $request)
    {
        $datos = request()->except(['_token']);
        $doc = $datos['idDoc'];
        //$usuario = Auth::user()->username;
        //$users = User::all();       
       //$actions = Action::all();
        //$flows =ViewFlowUser::where('username', '=', $usuario)->get();
        //$documents = Document::where('flow_id', '=', $flow)->get();  
        $versions = Version::where('document_id', '=', $doc)->get();
        $document = Document::where('id', '=', $doc)->get();
        if(count($document)>0){
            $document =  $document[0];
        }else {
            $document = null;
        }
        return view('documentFlow.historial',compact('doc', 'versions', 'document'));
  
    }


    /**
     * Display a panel of a resource.
     *
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function openPanel(Request $request){
        $datos = request()->except(['_token']);
        $code =$datos['code'];

        if ($code == 1){
            return $this->preview($datos);

        }else if($code == 2 ){
            return $this->listNotes($datos);

        }else if($code == 3){
            return $this->downloadVersion($datos);

        }else if($code == 4){
            return $this->listVersionAction($datos);

        }        
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


    /**
     * Refresh the table on the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh($flow) {
        $usuario = Auth::user()->username;
        
        //$Flows = Flow::all();
        $users = User::all();
       
          $actions = Action::all();
       // $flowsUser = ViewFlowUser::all();
        $flows =ViewFlowUser::where('username', '=', $usuario)->get();
        //$flow = $flows->first()->flow_id;
        $documents = Document::where('flow_id', '=', $flow)->get();
        return view('documentFlow.table',compact('flow','flows', 'users','documents','actions'));
    }




    /**
     * List the notes for a specific version.
     *
     * @return \Illuminate\Http\Response
     */
    public function listNotes($datos){
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $notes = Note::where('version_id', '=', $version)->get();       
        return view('documentFlow.notes',compact('version','notes','versionNum'));
    }


    public function listVersionAction($datos){
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $actions = Historial::where('version_id', '=', $version)->get();       
        return view('documentFlow.actionHistory',compact('version','actions','versionNum'));
        
    }

    public function preview($datos){
        
    }

    public function downloadVersion($datos){
        
    }
}
