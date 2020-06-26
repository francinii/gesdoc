<?php

namespace App\Http\Controllers;



use Auth;
use App\Document;
use App\StepStep;
use App\Flow;
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validacion = [
            'description' => ['required', 'string', 'max:500'],
            'flow_id' => ['required'],            
            'code' => ['required', 'string', 'max:500'],
            'summary' => ['required', 'string', 'max:1000'],
            'docType' => ['required', 'string', 'max:500'],
            'state_id' => ['required', 'int'],
            'version' => ['required', 'int'],
            'mode' => ['required', 'int'],
        ];
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
        $document = $request->except('_token', 'documents');
        
        $mode =  $document['mode'];        
        if($mode == 1)
        $this->uploadFile($document);
        else {
            $this->createDocument( $document);
        }    
        return  $this->refresh('1', 0);
    }



    private function uploadFile($document){
        $mode = $document['mode'];

        
    }

    private function createDocument( $document){
        //$description = "'".$datos['description']."'"; 
        

        $size =  "'".$document['size']. "'";
        $username = "'". $document['user_id']. "'";
        $id_flow =  $document['flow_id']== '-1'? 'NULL': $document['flow_id'] ;   //int     
        $route =  "'". $document['route'] . "'";
        $content =   "'".$document['content'] ."'";
        $code =   "'".$document['code'] ."'";
        $summary =   "'".$document['summary'] ."'";
        $type =  "'". $document['docType'] ."'";
        $id_state =  1;//$document['state_id']; //int
        $description = "'".$document['description']."'";
        $version =  1; //$document['version']; //int


        $step = StepStep::where('prev_flow_id', '=', $id_flow, 'and','prev_step_id', '=', 'draggable_inicio')->get();
        $identifier =  "'".$step->next_step_id."'";
        

        $classification = '1'; // Por defecto se agrega a la classifcacion 1 que es el principal
        //falta el type
        //  `p_mode` int, `p_route` varchar(500), `p_content` longtext, `p_id_flow` int,  `p_id_state` int, `p_username` varchar(500), IN `p_description` varchar(500), `p_type` varchar(500), `p_summary` varchar(2500) , `p_code` varchar(500), `version` int 
        DB::select("call insert_document($size, $classification, $route, $content, $id_flow, $id_state, $username, $description, $type, $summary, $code, $version,$identifier, @res)");
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
        //
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
        $this->validator($request->all())->validate();
        $dato = request()->except(['_token','_method']);
        $id = $dato['id'];
        Document::where('id', '=', $id)->update($dato);
        return DocumentController::refresh();
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


    public function subirArchivo(Request $request)
    {
           //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
           $request->file('archivo')->store('public');
          // dd("subido y guardado");
    }

}
