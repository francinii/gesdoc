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
        $flows =ViewFlowUser::where('username', '=', $usuario)
        ->get();
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


    public function modalEditVersion(Request $request){
        $usuario = Auth::user()->username;
        $datos = request()->except(['_token']);
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $version = Version::where('id', '=', $version)->first();
        $stepId = $version->identifier;
        $flowId = $version->flow_id;

        // $stepstep = StepStep::where('prev_flow_id', '=', $flowId)
       // ->where('prev_step_id', $stepId)->get();
        
      //  $actionStepUser = ActionStepUser::where('flow_id', '=', $flowId)
      //  ->where('step_id', $stepId)
      //  ->where('username',  $usuario)->get(); 

     // $stepstep = StepStep::where('prev_flow_id', '=', $flowId)
      //->where('prev_step_id', $stepId)->pluck('id_action')->toArray();

        ///$actionStepUser = ActionStepUser::where('flow_id', '=', $flowId)
       // ->where('step_id', $stepId)
       // ->where('username',  $usuario)->pluck('action_id')->toArray(); 
       $actionStepUser = ViewActionStepStepUser::where('username','=', $usuario)
       ->where('step_id', $stepId)
       ->where('flow_id', $flowId)
       ->get();

    

        return view('documentFlow.modalEditVersion',compact('version','actionStepUser','versionNum'));

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
        if(!$oldVersion){
            $oldVersion = $actualVersion;
        }
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



    function flowProcess(Request $request){
        $datos = request()->except(['_token']);
        $idVersion = $datos['version'];
        $action = (int) $datos['action'];
        $text_notas =  "'" . $datos['text_notas']. "'"; 
        $isCheck = $datos['isCheck'];
        
        $version = Version::where('id', '=', $idVersion)->first();
        $document_id = $version->document_id;
        $flow_id = (int) $version->flow_id;
        $previewStep =  $version->identifier;
        $size =  "'" .$version->size . "'";
        $content = "'".$version->content. "'"; 
        $status = true;

        //Get the next identifier
        $identifier = StepStep::where('prev_flow_id', '=', $flow_id)->where('prev_step_id', '=', $previewStep)
        ->where('id_action', '=', $action)
        ->first();

        //Get the next version
        $identifier =  $identifier->next_step_id;
        $version = (double) $version->version;
        $version++;

//If the next step is the final step then
        if($identifier  == 'draggable_final'){
            $flow_id = -1;
            $identifier = '-1';
            
            //estado de la version a finalizado update de la version
            //estado del documento a finalizado update del documento  
            DB::select("call update_version_final( $document_id, $idVersion, @res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] == 3) {
                throw new DecryptException('El documento ya existe en la base de datos');
            }
            else if ($res[0]['res'] != 0) {
               throw new DecryptException('Error al procesar la petición en la base de datos');
            }
            if($isCheck && $text_notas != '' )
                DB::select("call insert_note($idVersion, $text_notas, @res)");
                $status = 11;
                DB::select("call update_document_status($document_id, $status , @res)");
        }
        else{
            $status = 0;
            $identifier =  "'" . $identifier . "'" ;
            DB::select("call update_version_status($idVersion, $status, @res)");
            DB::select("call insert_version($document_id, $flow_id, $identifier,$size, $content, $version, $status, @res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] == 3) {
                throw new DecryptException('El documento ya existe en la base de datos');
            }
            if ($res[0]['res'] != 0) {
                throw new DecryptException('Error al procesar la petición en la base de datos');
            }

            if($isCheck && $text_notas != '' )
                DB::select("call insert_note($idVersion, $text_notas, @res)");
        }
//Else 


    
        
  }







}
