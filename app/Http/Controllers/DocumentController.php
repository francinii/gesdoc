<?php

namespace App\Http\Controllers;



use Auth;
use App\Document;
use App\StepStep;
use App\Flow;
use App\Classification;
use DB;
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
        if($mode == 1){        
        $this->uploadFile($document,$request->file('archivo'));
        }
        else {
            $this->createDocument( $document);
        }    
        return  $this->refresh('1', 0);
    }



    private function uploadFile($document,$file){
        
        $username=Auth::id();
        $type =  "'". $file->extension()."'";
        $content="'".$file->store('public')."'";

        $size =  "'". $file->getSize()."'";
        $username = Auth::id();
        $id_flow =  $document['flow_id']== '-1'? -1: $document['flow_id'] ;   //int    
        $code =   "'".$document['code'] ."'";
        $summary =   "'".$document['summary'] ."'";      
        $id_state =  3;//$document['state_id']; //int
        $description = "'".$document['description']."'";
        $languaje="'".$document['languaje']."'";
        $othres="'".$document['othres']."'";
        $identifier =  "-1";    
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();    
        $classification=$document['classification']!='-1'?"'".$document['classification']."'":"'".$mainClassification->id."'";
        $username = "'". $username. "'";
        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();        
        if(count($step) >0){
            $identifier =  "'".$step[0]->next_step_id."'";
        }  

        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call insert_document($classification,$id_flow,$identifier,$id_state,$username, $description, $type, $summary, $code,$languaje,$othres,$size,$content, @res)");
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
        $id_state =  3;//$document['state_id']; //int
        $description = "'".$document['description']."'";
        $languaje="'".$document['languaje']."'";
        $othres="'".$document['othres']."'";
        $identifier =  "-1";    
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();    
        $classification=$document['classification']!='-1'?"'".$document['classification']."'":"'".$mainClassification->id."'";
        $username = "'". $username. "'";
        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();        
        if(count($step) >0){
            $identifier =  "'".$step[0]->next_step_id."'";
        }  

        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call insert_document($classification,$id_flow,$identifier,$id_state,$username, $description, $type, $summary, $code,$languaje,$othres,$size,$content, @res)");
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
        $othres="'".$document['othres']."'";
        $identifier =  "-1";    
        $username = Auth::id();    
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();    
        $classification=$document['classification']!='-1'?"'".$document['classification']."'":"'".$mainClassification->id."'";
        
        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();        
        if(count($step) >0){
            $identifier =  "'".$step[0]->next_step_id."'";
        }      

        

        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call update_document($id,$classification, $currentClassification,$id_flow,$identifier,$description, $summary, $code,$languaje,$othres,@res)");
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Document::destroy($id);
        return DocumentController::refresh();
    }

}
