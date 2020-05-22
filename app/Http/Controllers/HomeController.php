<?php

namespace App\Http\Controllers;

use App\Classification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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
        $allClassification=$classification = Classification::where([['username', '=',''.$username.''],['is_start', '=',true]])->first();      
        return view('home.home', compact('classification','allClassification'));
    }
    
    /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function refresh($currentClassification)
    {
        $username = Auth::id();
        $classification = Classification::where([['username', '=',''.$username.''],['id', '=',$currentClassification]])->first();    
        $allClassification=Classification::where([['username', '=',''.$username.''],['is_start', '=',true]])->first(); 
        return view('home.table', compact('classification','allClassification'));
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool $create
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    protected function validator(array $data)
    {
        $validacion = [           
            'description' => ['required', 'string', 'max:500'],
            'currentClassification'=>['required', 'int'],
        ];

        return Validator::make($data, $validacion);
    }
        /**
     * transform a array to string
     * @param array $create
     * @return String     
     */  
    protected function myArray(array $dato,$create)
    { 

        $username = Auth::id();        
        $arryString="'".$dato['description']."',".$dato['currentClassification'];
        if($create){
            $arryString.=",'".$username."'";
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
        $dato = request()->except(['_token']);
        $currentClassification=$dato['currentClassification'];
        $dato=$this->myArray($dato,true);  
        DB::select("call insert_classification($dato,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']==3)  throw new DecryptException('la clasificacion ya existe en la base de datos');
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh($currentClassification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $Department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
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
        $this->validator($request->all(),false)->validate();
        $dato = request()->except(['_token','_method']);
        $id = $dato['id'];
        $dato=$this->myArray($dato);  
        DB::select("call update_department($id,$dato,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select("call delete_department($id,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
    }
    
    public function classifications($classification)
    {
        $classifications;
        $arrayClassifications = array();

        $classifications['classification'] = $classification;
      
        foreach ($classification->classifications as $subClassification) {
            array_push($arrayClassifications, $this->classifications($subClassification));            
        }
        $classifications['classifications'] = $arrayClassifications;
        return $classifications;

    }

}
