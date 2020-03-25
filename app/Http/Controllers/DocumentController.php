<?php

namespace App\Http\Controllers;



use Auth;
use App\Document;
use App\Flow;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $usuario = Auth::user()->id;
       // $flows =Flow::where('user_id', '=', $usuario)->get();
        $documents = Document::all();
        $flows = Flow::all();
        return view('documents.index',compact('documents', 'flows'));
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
        $datos = $request->except(['_token', 'user_id'], 'documents');
        $document = $request->except('_token', 'documents');
        $usuario =  $document['user_id'];
        $idDocument = Document::insertGetId($datos);
        
            DB::table('document_user')->insert([
                'document_id' => $idDocument,
                'user_id' => $usuario ,
            ]);
        

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
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
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


    private function refresh()
    {
        $documents = Document::all();
        $flows = Flow::all();
        return view('documents.table',compact('documents', 'flows'));        
    }
}
