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

    public function listNotesModal(Request $request){
        $datos = request()->except(['_token']);
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $notes = Note::where('version_id', '=', $version)->get();       
        return view('documentFlow.notesContent',compact('version','notes','versionNum'));
    }

     /**
     * Display the specified historial of a resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function historial(Request $request)
    {
        $datos = request()->except(['_token']);
        $doc = $datos['idDoc'];
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
     * Display the preview view in the historial screen
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request){
        $datos = request()->except(['_token']);
        $doc = $datos['idDoc'];
        //retrived just one row the actual version
        $actualVersion = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->first();
        //retrived the version before the actual version
        $oldVersion = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->skip(1)->take(1)->first(); 
      //  $oldVersion = $actualVersion;
        return view('documentFlow.preview',compact('doc', 'actualVersion', 'oldVersion'));
    }



    /**
     * Show the next or preview version in the left panel of preview mode
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function nextVersion(Request $request){
        $datos = request()->except(['_token']);
        $opc = $datos['opc'];
        $version = $datos['version_num'];
        $version = (double) $version;
        $doc = (int )$datos['idDoc'];
        if($opc == '1')
            $version--; 
        else if($opc == '2')
            $version++; 

        $allVersions = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->get();     
        $oldVersion = Version::where('document_id', '=', $doc)->where('version', '=', $version)->first(); 
        $tam = $allVersions->count();
        if($tam > 0){ 
            if($version == 0){           
               $oldVersion =  $allVersions[0];
            }          
            else if($version > $allVersions[0]->version ){
                $oldVersion =  $allVersions[$tam-1];
            }
        }
       
        return view('documentFlow.oldVersion',compact('doc','oldVersion'));
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
            return $this->previewVersion($datos);

        }else if($code == 2 ){
            return $this->listNotes($datos);

        }else if($code == 3){
            return $this->downloadVersion($datos);

        }else if($code == 4){
            return $this->listVersionAction($datos);

        }        
    }


    public function listVersionAction($datos){
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $actions = Historial::where('version_id', '=', $version)->get();       
        return view('documentFlow.actionHistory',compact('version','actions','versionNum'));
        
    }

    public function previewVersion($datos){
        $datos = request()->except(['_token']);
        $idVersion = $datos['version'];
        $versionNum = $datos['versionNum'];

        //retrived just one row the actual version
        $version = Version::where('id', '=', $idVersion)->first();
        //retrived the version before the actual version
        return view('documentFlow.previewHistory',compact('version', 'versionNum'));
       
    }
    public function downloadVersion($datos){
        
    }








}
