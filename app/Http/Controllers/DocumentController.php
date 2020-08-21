<?php

namespace App\Http\Controllers;



use Auth;
use App\Document;
use App\StepStep;
use App\Flow;
use App\Classification;
use App\User;
use File;
use Storage;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RefreshHomeTrait;

class DocumentController extends Controller
{

    use RefreshHomeTrait;
    /*
    |--------------------------------------------------------------------------
    | Document Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the documents' resources. That 
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
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool $create is creating classfication
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data,$create)
    {
        $validacion = [
            'description' => ['required', 'string', 'max:500'],
            'flow_id' => ['required'],          
            'summary' => ['required', 'string', 'max:1000'],
            'languaje' => ['required', 'string', 'max:500'],
            'currentClassification' => ['required', 'int'],

        ];
        if($create)
        $validacion['docType']=['required', 'string', 'max:500'];

        return Validator::make($data, $validacion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       //
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
        //$this->validator($request->all())->validate();
       // $datos = $request->except(['_token', 'user_id'], 'documents');
        $document = $request->except('_token');        
        $mode =  $document['mode'];    
        $this->validator($request->all(),true)->validate();
        $currentClassification = $document['currentClassification'];
        $currentTable = $document['currentTable']; 
       
        if($mode == 1){        
        $this->uploadFile($document,$request->file('archivo'));
        }
        else {
            $this->createDocument( $document);
        }    
        return  $this->refresh($currentTable, $currentClassification);
    }



    private function uploadFile($document,$file){
        
        $username=Auth::id();
        $type =  $file->extension();
        if($type=='')  $type = $document['docType'];
        $name=$file->getClientOriginalName();
        $hasname=md5($username.$name.uniqid()).uniqid();
        $content="'".$file->storeAS('public',$hasname.'.'.$type)."'";
        $type =  "'". $type ."'";
        $size =  "'". $file->getSize()."'";
        $username = Auth::id();
        $id_flow =  $document['flow_id']== '-1'? -1: $document['flow_id'] ;   //int    
        $code =   "'".$document['code'] ."'";
        $summary =   "'".$document['summary'] ."'";      
        $id_state =  3;//$document['state_id']; //int
        $description = "'".$document['description']."'";
        $languaje="'".$document['languaje']."'";
        $others="'".$document['others']."'";
        $identifier =  "-1";    
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();    
        $classification=$document['classification']!='-1'?"'".$document['classification']."'":"'".$mainClassification->id."'";
        $myUsers=DB::table('action_classification_user')->select('username')->where('classification_id','=', $classification)->groupBy('username')->pluck('username')->toArray();   
        $UsersString='';
        foreach ($myUsers as $User) {
            $UsersString.="$User,";
        }
        $UsersString=substr($UsersString, 0, -1);
        $username = "'". $username. "'";
        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();        
        if(count($step) >0){
            $identifier =  "'".$step[0]->next_step_id."'";
        }  

        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call insert_document($classification,$id_flow,$identifier,$id_state,$username, $description, $type, $summary, $code,$languaje,$others,$size,$content,'$UsersString', @res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] == 3) {
            throw new DecryptException('El documento ya existe en la base de datos');
        }
        if ($res[0]['res'] != 0) {
            throw new DecryptException('Error al procesar la petición en la base de datos');
        }

        
    }

    private function createDocument( $document){
               
        $size =  "'0KB'";
        $username = Auth::id();
        $id_flow =  $document['flow_id']== '-1'? -1: $document['flow_id'] ;   //int 
        $currentClassification = $document['currentClassification'];
        $currentTable = $document['currentTable'];    
        $content =   "''";
        $code =   "'".$document['code'] ."'";
        $summary =   "'".$document['summary'] ."'";
        $type =  "'". $document['docType'] ."'";
        if($id_flow == -1){
            $id_state =  3; //Si no esta en flujo queda como Nuevo
        }else {
            $id_state =  10; //Estado en Flujo
        }        
        $description = "'".$document['description']."'";
        $languaje="'".$document['languaje']."'";
        $others="'".$document['others']."'";
        $identifier =  "-1";    
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();    
        $classification=$document['classification']!='-1'?$document['classification']:$mainClassification->id;
        $myUsers=DB::table('action_classification_user')->select('username')->where('classification_id','=', $classification)->groupBy('username')->pluck('username')->toArray();   
        $UsersString='';
        foreach ($myUsers as $User) {
            $UsersString.="$User,";
        }
        $UsersString=substr($UsersString, 0, -1);
        $username = "'". $username. "'";
        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();        
        if(count($step) >0){
            $identifier =  "'".$step[0]->next_step_id."'";
        }  

        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call insert_document($classification,$id_flow,$identifier,$id_state,$username, $description, $type, $summary, $code,$languaje,$others,$size,$content,'$UsersString', @res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] == 3) {
            throw new DecryptException('El documento ya existe en la base de datos');
        }
        if ($res[0]['res'] != 0) {
            throw new DecryptException('Error al procesar la petición en la base de datos');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {

       // dd("subido y guardado");
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {

       // dd("subido y guardado");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator($request->all(),false)->validate();
        $document = request()->except(['_token','_method']);
        $id = $document['id'];
        $currentClassification = $document['currentClassification'];
        $currentTable = $document['currentTable'];
        $id_flow =  $document['flow_id']== '-1'? -1: $document['flow_id'] ;   //int     
        $code =   "'".$document['code'] ."'";
        $summary =   "'".$document['summary'] ."'";
        $description = "'".$document['description']."'";
        $languaje="'".$document['languaje']."'";
        $others="'".$document['others']."'";
        $identifier =  "-1";    
        $username = Auth::id();    
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();    
        $classification=$document['classification']!='-1'?"'".$document['classification']."'":"'".$mainClassification->id."'";
        $username = "'". $username. "'";
        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();        
        if(count($step) >0){
            $identifier =  "'".$step[0]->next_step_id."'";
        }      

        

        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call update_document($id,$username,$classification, $currentClassification,$id_flow,$identifier,$description, $summary, $code,$languaje,$others,@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] == 3) {
            throw new DecryptException('El documento ya existe en la base de datos');
        }
        if ($res[0]['res'] != 0) {
            throw new DecryptException('Error al procesar la petición en la base de datos');
        }
        


        return $this->refresh($currentTable, $currentClassification);
    }

    /**
     * @param id of the document or classification
     * @param type  document or classification
     * @return array of user
     */
    public function showShare($id)
    {
        $currentUsersShare = [];
        $review = [];
        $Document = Document::where([['id', '=', $id]])->first();
        $owner=$Document->owner;
        $owner->owner=true;
        $CurrentUsername = Auth::id();
        ($CurrentUsername== $owner->username)? $owner->current=true : $owner->current=false;
        $currentUsersShare[$owner->username] = $owner;
        $currentUsersShare[$owner->username]->actions=[];       
        $this->getUsersDocuments($Document->id,$currentUsersShare,$CurrentUsername);   
        

       return compact('currentUsersShare');
    }

    
     /**
     * @param classification for find the user who can see
     * @param currentUsersShare array to save users
     * @param review save the classification reviewed
     * @return idclassification id of the main classification
     */
    private function getUsersDocuments($idDocument,&$currentUsersShare,$CurrentUsername)
    {        
        
        $myUsers=DB::table('action_document_user')->select('username')->where('document_id','=', $idDocument)->pluck('username')->toArray();
        $myUsers=User::whereIn('username', $myUsers)->get();
        foreach ($myUsers as $user) {
            if(!isset($currentUsersShare[$user->username])){                
                $user->owner=false;
                ($CurrentUsername== $user->username)? $user->current=true :$user->current=false;
                $myActions=  DB::table('action_document_user')->select('action_id')->where([['document_id','=', $idDocument],['username','=',$user->username]])->pluck('action_id')->toArray();
                $user->actions=$myActions;  
                $currentUsersShare[$user->username]=$user;
            }          
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user(); 
        $array = explode('-', $id);
        $idselect = (int) $array[0];
        $action = $array[1];
        $currentClassification = (int) $array[2];
        $currentTable = (int) $array[3];
        
        if($action=="1")
        $this->DeleteShare($user,$idselect,$currentClassification,null);
        else
        $this->remove($user,$idselect,$currentClassification);

        return $this->refresh($currentTable, $currentClassification);
    }

    private function DeleteShare($user,$idselect,$currentClassification,$Owner){
        if($Owner==null) $this->deletefiles($idselect);     
        $user_logged = Auth::id();
        DB::select("call delete_Share_document($idselect,'$user->username',$currentClassification,'$Owner',  '$user_logged', @res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }
    
    }

    private function remove($user,$idselect,$currentClassification){
        $user_logged = Auth::id();
        DB::select("call remove_document($idselect,'$user->username',$currentClassification,'$user_logged' ,@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }

    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * Save the users to share a documents
     */

    public function share(Request $request)
    {
        $dato = request()->except(['_token']);
        $usersShare=$dato['usersShare'];
        $type=$dato['typeContextMenu'];
        $idselect=$dato['idselect'];     
        $Owner=$dato['Owner'];
        $currentTable=$dato['currentTable'];
        $currentClassification=$dato['currentClassification'];

        foreach ($usersShare as $user) {
            $user=(object)$user;
            if($user->type=='delete')
                $this->DeleteShare($user,$idselect,$currentClassification,$Owner);
            if($user->type=='new')
                $this->addShare($user,$idselect,$currentClassification,$Owner);
            if($user->type=='old')
                $this->updateShare($user,$idselect,$currentClassification,$Owner);
        }
        return $this->refresh($currentTable, $currentClassification);
        
    }
    
    /**
     * @param  user user for add to document
     * @param idselect id of the document
     * @param owner of de document
     * add  the users to share a documents
     */

    private function addShare($user,$idselect,$currentClassification,$Owner){
        
            $actionsString='';
            if(isset($user->actions)){
                foreach ($user->actions as $action) {
                    $actionsString.="$action,";
                }
                $actionsString=substr($actionsString, 0, -1);
            }

            $myUsers=DB::table('action_classification_user')->select('username')->where([['classification_id','=', $currentClassification],['username','=',$user->username]])->pluck('username')->toArray();
            (count($myUsers)>0)?$classification=$currentClassification:$classification=null;
            $user_logged = Auth::id();
            DB::select("call add_Share_document($idselect,'$user->username','$classification','$Owner','$actionsString', '$user_logged',@res)");
            $res = DB::select("SELECT @res as res;");
            $res = json_decode(json_encode($res), true);
            if ($res[0]['res'] != 0) {
                throw new DecryptException('error en la base de datos');
            }
     
      
    }

    /**
     * @param  user user for add to document
     * @param idselect id of the document
     * @param owner of de document
     * update  the users to share a documents
     */

    private function updateShare($user,$idselect,$currentClassification,$Owner){
                 
            $actionsString='';
            if(isset($user->actions)){
                foreach ($user->actions as $action) {
                    $actionsString.="$action,";
                }
                $actionsString=substr($actionsString, 0, -1);
            }
                $user_logged = Auth::id();
                DB::select("call update_Share_document($idselect,'$user->username','$currentClassification','$Owner','$actionsString', '$user_logged',@res)");
                $res = DB::select("SELECT @res as res;");
                $res = json_decode(json_encode($res), true);
                if ($res[0]['res'] != 0) {
                    throw new DecryptException('error en la base de datos');
                }
            
    }

    
    /**
     * @param  id of the document
     * clone a document for id
     */
    public function clone($id){
        $dato = request()->except(['_token']);
        $idselect=$dato['id'];
        $currentClassification=$dato['currentClassification'];
        $currentTable=$dato['currentTable'];
        $myUsers=DB::table('action_classification_user')->select('username')->where('classification_id','=', $currentClassification)->groupBy('username')->pluck('username')->toArray();   
        $UsersString='';
        foreach ($myUsers as $User) {
            $UsersString.="$User,";
        }
        $UsersString=substr($UsersString, 0, -1);

        $content=DB::table('versions')->select('version','content')->where('document_id','=', $idselect)->orderBy('version', 'desc')->pluck('content')->toArray();
        $file = storage_path('app/'.$content[0]);
        $exists = File::exists($file);
        if($exists && $content[0]!=''){
        $ext = pathinfo(storage_path('app/'.$content[0]), PATHINFO_EXTENSION);
        $username = Auth::id();
        $name= $content[0];       
        $name=md5($username.$name.uniqid()).uniqid();
        $route='public/'.$name.'.'.$ext;
        $destination = storage_path('app/'.$route);    
        $success = File::copy($file,$destination);
        $content=$route;
        }else $content=$content[0];
        
        DB::select("call clone_document($idselect,$currentClassification,'$content','$UsersString',@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }
        return $this->refresh($currentTable, $currentClassification);
    }

    /**
     * @param  id of the document
     * @param  edit 1 mode edition 0 mode view
     * clone a document for id
     */
    public function openDocument($id,Request $request){
        $username = Auth::id();
        $user=User::where('username',$username) -> first();
        $dato = request()->except(['_token']);
        $version=$dato['version'];
        $mode=$dato['mode'];
        $edit=$dato['edit'];
        $document=$id."-".$version."-".$mode."-".$edit;        
        $api_token=$user->api_token;
<<<<<<< HEAD
        return view('documents.wopihost', compact('api_token','documet', 'id'));
=======
        return view('documents.wopihost', compact('api_token','document'));
>>>>>>> 3a7228ca183e994e69dc3d58f91e572d85edcb75
    }


}

