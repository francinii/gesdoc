<?php

namespace App\Http\Controllers;



use Auth;
use App\Documento;
use App\Flujo;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $usuario = Auth::user()->id;
       // $flujos =Flujo::where('userId', '=', $usuario)->get();
        $documentos = Documento::all();
        $flujos = Flujo::all();
        return view('documentos.index',compact('documentos', 'flujos'));
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
        $datos = $request->except(['_token', 'userId'], 'documentos');
        $documento = $request->except('_token', 'documentos');
        $usuario =  $documento['userId'];
        $idDocumento = Documento::insertGetId($datos);
        
            DB::table('documento_users')->insert([
                'documentoId' => $idDocumento,
                'userId' => $usuario ,
            ]);
        

        return DocumentoController::refresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Documento::destroy($id);
        return DocumentoController::refresh();
    }


    private function refresh()
    {
        $documentos = Documento::all();
        $flujos = Flujo::all();
        return view('documentos.table',compact('documentos', 'flujos'));        
    }
}
