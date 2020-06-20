<?php

namespace App\Http\Controllers;



use Auth;
use App\Document;
use App\Flow;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
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
            'flow_id' => ['required', 'int'],
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
        $this->validator($request->all())->validate();
       // $datos = $request->except(['_token', 'user_id'], 'documents');
        $document = $request->except('_token', 'documents');
        $username =  $document['user_id'];
        $id_flow =  $document['flow_id'];        
        $route =  $document['route'];
        $content =  $document['content'];
        $code =  $document['code'];
        $summary =  $document['summary'];
        $type =  $document['docType'];
        $id_state =  $document['state_id'];
        $description =  $document['description'];
        $version =  $document['version'];
        $mode =  $document['mode'];
        //falta el type
        DB::select("call insert_document($mode, $route, $content, $id_flow, $id_state, $username, $description, $type, $summary, $code, $version, @res)");
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] == 3) {
            throw new DecryptException('El documento ya existe en la  base de datos');
        }

        if ($res[0]['res'] != 0) {
            throw new DecryptException('Error al procesar la petición la base de datos');
        }

        

        return DocumentController::refresh();
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


    /**
     * Refresh the table on the view.
     *
     * @return \Illuminate\Http\Response
     */
    private function refresh()
    {
        $documents = Document::all();
        $flows = Flow::all();
        return view('documents.table',compact('documents', 'flows'));        
    }
}
