<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Flow;
use App\User;
//use App\Department;
use App\Document;
use App\Version;
use App\Action;
use App\Note;
use App\Historial;
//use App\ViewFlowUser;
use App\ActionStepUser;
use App\Http\Controllers\Traits\HomeTrait;
use App\StepStep;
use App\Step;
use App\ViewActionStepStepUser;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class DocumentFlowController extends Controller
{
    use HomeTrait;
    

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
        $username = Auth::user()->username;
        $permissions = Auth::user()->role->permissions;
        $permissionsArray = $permissions->pluck('id')->toArray();

        if (in_array(5, $permissionsArray)) { // permission to see the documento Flow screen
           
            $users = User::all();
            $actions = Action::all();
            $flow = '';
            $flows = Flow::where('username', '=', $username)->get();
            if ($flows->isNotEmpty()) {
                $flow = $flows->first()->id;
            }
            $documents = Document::where('flow_id', '=', $flow)->get();
            $notifications = Notification::where('username', '=', $username)->get(); 
            return view('documentFlow.index', compact('flow', 'flows', 'users', 'documents', 'actions','notifications'));
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


    /**
     * Refresh the table on the view.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh($flow)
    {
        $username = Auth::user()->username;

        $users = User::all();
        $actions = Action::all();
        $flows = Flow::where('username', '=', $username)->get();

        //$flow = $flows->first()->flow_id;
        $documents = Document::where('flow_id', '=', $flow)->get();
        $notifications = Notification::where('username', '=', $username)->get(); 
        return view('documentFlow.table', compact('flow', 'flows', 'users', 'documents', 'actions','notifications'));
    }

    /**
     * List the notes for a specific version.
     *
     * @return \Illuminate\Http\Response
     */
    public function listNotes($datos)
    {
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $notes = Note::where('version_id', '=', $version)->get();
        return view('documentFlow.notes', compact('version', 'notes', 'versionNum'));
    }

    public function listNotesModal(Request $request)
    {
        $datos = request()->except(['_token']);
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $notes = Note::where('version_id', '=', $version)->get();
        return view('documentFlow.notesContent', compact('version', 'notes', 'versionNum'));
    }


    public function modalEditVersion(Request $request)
    {
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
        $actionStepUser = ViewActionStepStepUser::where('username', '=', $usuario)
            ->where('step_id', $stepId)
            ->where('flow_id', $flowId)
            ->get();



        return view('documentFlow.modalEditVersion', compact('version', 'actionStepUser', 'versionNum'));
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
        if (count($document) > 0) {
            $document =  $document[0];
        } else {
            $document = null;
        }
        return view('documentFlow.historial', compact('doc', 'versions', 'document'));
    }

    /**
     * Display the preview view in the historial screen
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $datos = request()->except(['_token']);
        $doc = $datos['idDoc'];
        $version = $datos['version'];
        $mode=$datos['mode'];
        $edit=$datos['edit'];
        $screen=$datos['screen']; // 1 is documentFlow.preview 2
        //retrived just one row the actual version
        $actualVersion = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->first();
        //retrived the version before the actual version
        $oldVersion = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->skip(1)->take(1)->first();
        if (!$oldVersion) {
            $oldVersion = $actualVersion;
        }
        $allVersions = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->get()->pluck('id')->toArray();;
        //  $oldVersion = $actualVersion;

        $username = Auth::id();
        $user=User::where('username',$username) -> first();
        $api_token=$user->api_token;
        $document=$doc."-".$version."-".$mode."-".$edit;        
        $api_token=$user->api_token;
        return view('documentFlow.preview', compact('doc', 'actualVersion', 'allVersions','oldVersion','api_token','document', 'screen'));
    }



    /**
     * Show the next or preview version in the left panel of preview mode
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function nextVersion(Request $request)
    {
        $datos = request()->except(['_token']);
        $opc = $datos['opc'];
        $version = $datos['version_num'];
        $mode=$datos['mode'];
        $version = (float) $version;
        $edit=$datos['edit'];
        
        $doc = (int)$datos['idDoc'];

        $oldVersion = Version::where('document_id', '=', $doc)->where('version', '=', $version)->first();


        $username = Auth::id();
        $user=User::where('username',$username) -> first();
        $api_token=$user->api_token;
        $document=$doc."-".$version."-".$mode."-".$edit;        
        $api_token=$user->api_token;
        return view('documentFlow.oldVersion', compact('doc', 'oldVersion','api_token','document'));
    }

    /**
     * Show the next or preview version in the left panel of preview mode
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function editionMode(Request $request)
    {
        $datos = request()->except(['_token']);
        $version = $datos['versionNum'];
        $mode=$datos['mode'];
        $version = (float) $version;
        $edit=$datos['edit'];
        
        $doc = (int)$datos['document_id'];

        $actualVersion = Version::where('document_id', '=', $doc)->where('version', '=', $version)->first();


        $username = Auth::id();
        $user=User::where('username',$username) -> first();
        $api_token=$user->api_token;
        $document=$doc."-".$version."-".$mode."-".$edit;        
        $api_token=$user->api_token;
        $screen=2;
        return view('documentFlow.actualVersion', compact('actualVersion','api_token','document','screen'));
    }

    /**
     * Display a panel of a resource.
     *
     * @param  \App\StepStep  $stepStep
     * @return \Illuminate\Http\Response
     */
    public function openPanel(Request $request)
    {
        $datos = request()->except(['_token']);
        $code = $datos['code'];

        if ($code == 1) {
            return $this->previewVersion($datos);
        } else if ($code == 2) {
            return $this->listNotes($datos);
        } else if ($code == 3) {
            return $this->downloadVersion($datos);
        } else if ($code == 4) {
            return $this->listVersionAction($datos);
        }
    }


    public function listVersionAction($datos)
    {
        $version = $datos['version'];
        $versionNum = $datos['versionNum'];
        $actions = Historial::where('version_id', '=', $version)->get();
        return view('documentFlow.actionHistory', compact('version', 'actions', 'versionNum'));
    }

    public function previewVersion($datos)
    {
        $datos = request()->except(['_token']);
        $idVersion = $datos['version'];
        $versionNum = $datos['versionNum'];
        $document = $datos['document'];
        $mode=2; // 2 mode flow
        $edit=2; // 2 prewiew  

        //retrived just one row the actual version
        $version = Version::where('id', '=', $idVersion)->first();
        //retrived the version before the actual version
        $username = Auth::id();
        $user=User::where('username',$username) -> first();
        $api_token=$user->api_token;
        $document=$document."-".$versionNum."-".$mode."-".$edit;        
        $api_token=$user->api_token;

        return view('documentFlow.previewHistory', compact('version', 'versionNum','api_token','document'));
    }

    public function downloadVersion($datos)
    {
    }



    function flowProcess(Request $request)
    {
        $datos = request()->except(['_token']);
        $idVersion = $datos['version'];
        $action = (int) $datos['action'];
        $text_notas =  "'" . $datos['text_notas'] . "'";
        $isCheck = $datos['isCheck'];

        $version = Version::where('id', '=', $idVersion)->first();
        $document_id = $version->document_id;
        $flow_id = (int) $version->flow_id;
        $previewStep =  $version->identifier;
        $size =  "'" . $version->size . "'";
        $content = "'" . $version->content . "'";
        $status = 0;

        //Get the next identifier
        $identifier = StepStep::where('prev_flow_id', '=', $flow_id)->where('prev_step_id', '=', $previewStep)
            ->where('id_action', '=', $action)
            ->first();

        //Get the next version
        $identifier =  $identifier->next_step_id;
        $version = (float) $version->version;
        $version++;

        //If the next step is the final step then
        $user_logged = Auth::id();
        if ($identifier  == 'draggable_final') {
            $flow_id = -1;
            $identifier = '-1';
           
            //estado de la version a finalizado update de la version
            //estado del documento a finalizado update del documento  
            DB::select("call update_version_final( $document_id, $idVersion,'$user_logged', @res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] == 3) {
                throw new DecryptException('El documento ya existe en la base de datos');
            } else if ($res[0]['res'] != 0) {
                throw new DecryptException('Error al procesar la petición en la base de datos');
            }
            if ($isCheck && $text_notas != '')
                DB::select("call insert_note($idVersion, $text_notas, @res)");
            $status = 11;
            DB::select("call update_document_status($document_id, $status , @res)");
        } else {
            $status = 1;

            $myUsers=DB::table('action_step_user')->select('username')->where([['flow_id','=', $flow_id],['step_id','=', $identifier]])->groupBy('username')->pluck('username')->toArray();   
            $userFlow='';
            foreach ($myUsers as $User) {
                $userFlow.="$User,";
            }
            $userFlow=substr($userFlow, 0, -1);


            $identifier =  "'" . $identifier . "'";

            DB::select("call update_version_status($idVersion, $status, @res)");
            DB::select("call insert_version($document_id, $flow_id, $identifier,$size, $content, $version, $status,'$user_logged',$userFlow, @res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] == 3) {
                throw new DecryptException('El documento ya existe en la base de datos');
            }
            if ($res[0]['res'] != 0) {
                throw new DecryptException('Error al procesar la petición en la base de datos');
            }

            if ($isCheck && $text_notas != '')
                DB::select("call insert_note($idVersion, $text_notas, @res)");
        }
    }




    //function managmentDocFlow(){
    //$usuario = Auth::user()->username;        
    //$users = User::all();        
    //$actions = Action::all();
    //$flow = '';
    //$flows =ViewFlowUser::where('username', '=', $usuario)->get();
    // if($flows->isNotEmpty()){
    //   $flow = $flows->first()->flow_id;
    //}   
    // $documents = Document::where('flow_id', '=', $flow)->get();
    //  return view('documentFlow.managmentDocFlow',compact('flow','flows', 'users','documents','actions'));
    // }


    function location(Request $request)
    {
        //ubicacion de la ultima version
        // usuarios asociados a la ultima version
        $datos = request()->except(['_token']);
        $doc = $datos['idDoc'];
        $actualVersion = Version::where('document_id', '=', $doc)->orderBy('version', 'desc')->first();
        $identifier = $actualVersion != null ?   $actualVersion->identifier : null;
        $flowId = $actualVersion != null ?   $actualVersion->flow_id : null;

        $step = Step::where('flow_id', '=', $flowId)
            ->where('id', '=', $identifier)->first();

        $users = ActionStepUser::where('flow_id', '=', $flowId)
            ->where('step_id', '=', $identifier)->pluck('username')->toArray();
        $users = User::whereIn('username', $users)->get();

        return view('documentFlow.location', compact('users', 'step'));
    }

    public function updateDocument($doc,Request $request){
        $datos = request()->except(['_token']);
        $idVersion = $datos['version'];
        $version = $datos['versionNum'];
        $doc = $datos['document_id'];
        $mode=2; // 2 mode flow
        $edit=2; // 2 prewiew  
        $file=$request->file('archivo');
        $username = Auth::id();
        $content=DB::table('versions')->select('version','content')->where([['document_id','=', $doc],['version','=',$version]])->pluck('content')->toArray();
        $array = explode('/', $content[0]);
        $content=$array[1];
        $file->storeAS('public',$content);
    
        DB::select("call save_document($doc,'$username',@res)");      
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] != 0) {
                throw new DecryptException('error en la base de datos');
            }
            
        $actualVersion = Version::where('document_id', '=', $doc)->where('version', '=', $version)->first();
        $user=User::where('username',$username) -> first();
        $api_token=$user->api_token;
        $document=$doc."-".$version."-".$mode."-".$edit;        
        $api_token=$user->api_token;
        return view('documentFlow.actualVersion', compact('actualVersion','api_token','document'));
    }






}

