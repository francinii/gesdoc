<?php

namespace App\Http\Controllers;

use App\Flow;
use App\User;
use App\Department;
use App\Action;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class FlowController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Flow Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the flows' resources. That 
    | includes listening, showing, storing, creating and updating working
    | flows.
    |
    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Auth::user()->username;
        $flows =Flow::where('username', '=', $usuario)->get();
        //$Flows = Flow::all();
        $users = User::all();
        $departments = Department::all();
        $actions = Action::where('type', '=', 1)->get();
        return view('Flows.index',compact('flows', 'users','departments','actions'));
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
       // $datos = $request->except('_token', 'flows');
       // $flows = request('flows');
       // Flow::insert($datos);
       // return FlowController::refresh();

      //  $this->validator($request->all(),true)->validate();
        $data = request()->except(['_token']);  
        $res = $this->insertFlow($data);
        
        $id_flow = $res[0]['id_flow'] ;
        $this->insertStep($data, $id_flow);         

        $this->insertStepStep($data, $id_flow);

        $this->insertStepUser($data, $id_flow);

        $this->insertActionStepUser($data, $id_flow);

        return $this->refresh();
    }


    /**
     * Insert to the Table flow
     * @param array $create
     * @return String     
     */  
    protected function insertFlow(array $datos)
    {    
        $username = "'".$datos['username']."'";  
        $description = "'".$datos['description']."'";  
        DB::select("call insert_flow($username, $description, @res, @id_flow)");
        $res = DB::select("SELECT @res as res;"); 
        $idFlow = DB::select("SELECT @id_flow as id_flow;"); 
        $res = json_decode(json_encode($res), true);
        $idFlow = json_decode(json_encode($idFlow), true);

        if($res[0]['res']==3)  throw new DecryptException('El flujo ya existe en la base de datos');
        if($res[0]['res']!=0)  throw new DecryptException('Error en la base de datos');
        
        return $idFlow;
    }

    /**
     * Insert to the table Step
     * @param array $create
     * @return String     
     */  
    protected function insertStep(array $datos, $idFlow)
    {    
        $id_flow =  "'". $idFlow."'";
        
        $steps = json_decode(json_encode( $datos['data']), true);
    
        foreach ($steps as $step) {
            $identifier = "'". $step['id']."'";
            $description = "'". $step['description']."'";
            $axisY = ($step['axisY']== null)? 0 : $step['axisY'] ;
            $axisX =($step['axisX']== null)? 0 : $step['axisX'] ;
            DB::select("call insert_step($identifier, $id_flow, $description, $axisX, $axisY, @res)");
            $res=DB::select("SELECT @res as res;"); 
                                
        }   

        
       // $description = "'".$datos['description']."'";  
      ///  DB::select("call insert_flow($username, $description, @res)");
      //  $res=DB::select("SELECT @res as res;"); 
        return json_decode(json_encode($res), true);

    }


    /**
     * Insert to the table Step
     * @param array $create
     * @return String     
     */  
    protected function insertStepStep(array $datos, $idFlow)
    {    
        $id_flow =  $idFlow;
        $steps = json_decode(json_encode( $datos['data']), true);  
        if($steps != null){
        foreach ($steps as $step) {
            //Falta validar los datos que esten que no este vacio etc
            $pasos = array_key_exists('steps', $step) ? $step['steps']: null;
            
            if($pasos != null)
            foreach ($pasos as $paso) {
               $idInicial =  "'".$paso['begin']."'"; 
               $idFinal =  "'".$paso['end']."'";  
               $action =  $paso['action'];             
                if( $action != null){
                    DB::select("call insert_step_step($idInicial, $idFinal,$id_flow,$action, @res)");
                    $res=DB::select("SELECT @res as res;"); 
                }else {
                    $res = -1;
                }                                         
            }   
        }
    }
        return json_decode(json_encode($res), true);
    }



    protected function insertStepUser(array $datos, $idFlow)
    {    
        $flow_id =  $idFlow;
        $steps = json_decode(json_encode( $datos['data']), true);  
        if($steps != null)
        foreach ($steps as $step) {
            //Falta validar los datos que esten que no este vacio etc
            $users = array_key_exists('users', $step) ? $step['users']: null;            
            if($users != null)
            foreach ($users as $user) {
               $step_id =  "'".$step['id']."'";   
               $username =  "'".$user['username']."'";      
                DB::select("call insert_step_user($step_id, $flow_id, $username, @res)");
                $res=DB::select("SELECT @res as res;");                                                              
            }   
        }    
        return json_decode(json_encode($res), true);
    }
    protected function insertActionStepUser(array $datos, $idFlow) {    
        $flow_id =  $idFlow;
        $steps = json_decode(json_encode( $datos['data']), true);  
        $actions = array_key_exists('actions', $steps) ? $step['actions']: null; 
        if($actions != null){
        foreach ($actions as $action) {
            //Falta validar los datos que esten que no este vacio etc
            $acciones = array_key_exists('actions', $actions) ? $action['actions']: null;            
            if($acciones != null)            
            foreach ($acciones as $accion) {    
                $step_id =  "'".$action['id']."'";   
                $username =  "'".$action['username']."'";     
                $action =  $accion;   
                DB::select("call insert_action_step_user($step_id, $flow_id, $username,$action @res)");
                $res=DB::select("SELECT @res as res;");     
            }          
        }
    }
        return json_decode(json_encode($res), true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function show(Flow $flow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function edit(Flow $flow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dato = request()->except(['_token', '_method', 'flows']);
        $flows = request('flows');
        $id = $dato['id'];
        Flow::where('id', '=', $id)->update($dato);
        
        return FlowController::refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flow  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Flow::destroy($id);
        return FlowController::refresh();
    }

    /**
     * Refresh the table on the view.
     *
     * @return \Illuminate\Http\Response
     */
    private function refresh()
    {
        $usuario = Auth::user()->id;
        $flows =Flow::where('username', '=', $usuario)->get();
        //$flows = Flow::all();
        $users = User::all();
        $departments = Department::all();
        $actions = Action::where('type', '=', 1)->get();
        return view('flows.table',compact('flows', 'users','departments','actions'));
    }
}
