<?php

namespace App\Http\Controllers;

use App\Action;
use App\Classification;
use App\Department;
use App\Document;
use App\Flow;
use App\User;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RefreshHomeTrait;

class HomeController extends Controller
{

    use RefreshHomeTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $username = Auth::id();
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();
        $classifications = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 3]])->get();
        
        $departments = Department::all();
        $flows  = Flow::where('username', '=', '' . $username . '')->get();;
        $actions = Action::where('type', '=', 1)->get();
        $myActions=['owner'];

        return view('home.home', compact('mainClassification','classifications', 'flows','departments', 'actions','myActions'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool $create is creating classfication
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data, $create)
    {
        $validacion = [
            'description' => ['required', 'string', 'max:500'],
            'currentClassification' => ['required', 'int'],
        ];

        return Validator::make($data, $validacion);
    }
    /**
     * transform a array to string
     * @param array $create is creating classfication
     * @return String
     */
    protected function myArray(array $dato, $create)
    {

        $username = Auth::id();
        $arryString = "'" . $dato['description'] . "'";
        if ($create) {
            $arryString .= "," . $dato['currentClassification'] . ",'" . $username . "'";
        } else {
            $arryString .= "," . $dato['parentClassification'] . "," . $dato['id'];
        }
        return $arryString;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

     $dato = request()->except(['_token']);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all(), true)->validate();
        $dato = request()->except(['_token']);
        $currentClassification = $dato['currentClassification'];
        $currentTable = $dato['currentTable'];
        $description=$dato['description'];
        $username = Auth::id();
        DB::select("call insert_classification('$description','$username',@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] == 3) {
            throw new DecryptException('La clasificación ya existe en la base de datos');
        }

        if ($res[0]['res'] != 0) {
            throw new DecryptException('Error en la base de datos');
        }

        return $this->refresh($currentTable, $currentClassification);
    }

  /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $aqui = "edit";
        return $aqui;
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
        $this->validator($request->all(), false)->validate();
        $dato = request()->except(['_token']);
        $currentClassification = $dato['currentClassification'];
        $currentTable = $dato['currentTable'];
        $description=$dato['description'];
        $idselect=$dato['id'];
        DB::select("call update_classification('$description', $idselect,@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] == 3) {
            throw new DecryptException('la clasificacion ya existe en la base de datos');
        }

        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }

        return $this->refresh($currentTable, $currentClassification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $id
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
        $this->DeleteShare($user,$idselect,null);
        else
        $this->remove($user,$idselect);

        return $this->refresh($currentTable, $currentClassification);
    }


    private function DeleteShare($user,$idselect,$classificationOwner){
        $classification = Classification::where([['id', '=', $idselect]])->first();
        $documentInClassificationid=$this->getThingsInClassification($classification);
        $documentsString='';
        foreach ($documentInClassificationid as $documentId) {
            $documentsString.="$documentId,";
        }
        $documentsString=substr($documentsString, 0, -1);
        if($classificationOwner==null){
            foreach ($documentInClassificationid as $documentId) {
                $this->deletefiles($documentId);
            }
        }
        

        DB::select("call delete_Share_Classification($idselect,'$user->username','$documentsString','$classificationOwner',@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }
    
    }

    private function remove($user,$idselect){
        $classification = Classification::where([['id', '=', $idselect]])->first();
        $documentInClassificationid=$this->getThingsInClassification($classification);
        $documentsString='';
        foreach ($documentInClassificationid as $documentId) {
            $documentsString.="$documentId,";
        }
        $documentsString=substr($documentsString, 0, -1);

        DB::select("call remove_Classification($idselect,'$user->username','$documentsString',@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }

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
        $classification = Classification::where([['id', '=', $id]])->first();
        $owner=$classification->owner;
        $owner->owner=true;
        $CurrentUsername = Auth::id();
        ($CurrentUsername== $owner->username)? $owner->current=true : $owner->current=false;
        $currentUsersShare[$classification->owner->username] = $owner;
        $currentUsersShare[$classification->owner->username]->actions=[];       
        $this->getUsersClassification($classification->id,$currentUsersShare,$CurrentUsername);   
        

       return compact('currentUsersShare');
    }

     /**
     * @param classification for find the user who can see
     * @param currentUsersShare array to save users
     * @param review save the classification reviewed
     * @return idclassification id of the main classification
     */
    private function getUsersClassification($idclassification,&$currentUsersShare,$CurrentUsername)
    {
        
        $myUsers=DB::table('action_classification_user')->select('username')->where('classification_id','=', $idclassification)->pluck('username')->toArray();
        $myUsers=User::whereIn('username', $myUsers)->get();
        foreach ($myUsers as $user) {
            if(!isset($currentUsersShare[$user->username])){                
                $user->owner=false;
                ($CurrentUsername== $user->username)? $user->current=true :$user->current=false;
                $myActions=  DB::table('action_classification_user')->select('action_id')->where([['classification_id','=', $idclassification],['username','=',$user->username]])->pluck('action_id')->toArray();
                $user->actions=$myActions;  
                $currentUsersShare[$user->username]=$user;
            }          
        }

    }

    /**
    * @param classification for find the documents
    * @param review save the classifications reviewed
    * @param documentInClassificationid array for save the id of documents
    * 
    */
    private function getThingsInClassification($classification){
        $documentInClassificationid=[];
            foreach ($classification->documents as $document) {
                $documentInClassificationid[$document->id]=$document->id;
            }         
            return  $documentInClassificationid;

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
        $classificationOwner=$dato['Owner'];
        $currentTable=$dato['currentTable'];
        $currentClassification=$dato['currentClassification'];

        foreach ($usersShare as $user) {
            $user=(object)$user;
            if($user->type=='delete')
                $this->DeleteShare($user,$idselect,$classificationOwner);
            if($user->type=='new')
                $this->addShare($user,$idselect,$classificationOwner);
            if($user->type=='old')
                $this->updateShare($user,$idselect,$classificationOwner);
        }
        return $this->refresh($currentTable, $currentClassification);
        
    }
    


    private function addShare($user,$idselect,$classificationOwner){
        $classification = Classification::where([['id', '=', $idselect]])->first();
        $documentInClassificationid=$this->getThingsInClassification($classification);
        $documentsString='';
        foreach ($documentInClassificationid as $documentId) {
            $documentsString.="$documentId,";
        }
        $documentsString=substr($documentsString, 0, -1);
        $actionsString='';
        if(isset($user->actions)){
            foreach ($user->actions as $action) {
                $actionsString.="$action,";
            }
            $actionsString=substr($actionsString, 0, -1);
        }
        DB::select("call add_Share_Classification($idselect,'$user->username','$classificationOwner','$documentsString','$actionsString',@res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }
     
      
    }

    private function updateShare($user,$idselect,$classificationOwner){
                 
            $actionsString='';
            if(isset($user->actions)){
                foreach ($user->actions as $action) {
                    $actionsString.="$action,";
                }
                $actionsString=substr($actionsString, 0, -1);
            }
                DB::select("call update_Share_Classification($idselect,'$user->username','$classificationOwner','$actionsString',@res)");
                $res = DB::select("SELECT @res as res;");
                $res = json_decode(json_encode($res), true);
                if ($res[0]['res'] != 0) {
                    throw new DecryptException('error en la base de datos');
                }
            
        }
    
}
