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
        $data = request()->except(['_token']);  
        $res = $this->insertFlow($data);        
        $idFlow = $res[0]['id_flow'] ;
        $this->insert( $data, $idFlow);
        return $this->refresh();
    }

    /**
     * Insert to the entire process of a flow (flow, step, stepsteps, stepusers, actionstepuser)
     * @param array $datos
     * @param string $id_Flow   
     */  
    protected function insert(array $datos, $id_Flow)
    {
        $idFlow =  "'". $id_Flow."'";  
        $steps = json_decode(json_encode( $datos['data']), true);
        if($steps != null){
            //insertamos a la tabla de steps Es necesario que se agreguen los 
            //steps antes de ingresar datos a las otras tablas
            $this->insertStep($datos, $steps, $idFlow);

            foreach ($steps as $step) {                  
            //insertamos a la tabla de steps_steps
                $this->insertStepStep( $datos,  $step, $idFlow);
            //insertamos a la tabla de steps_steps
                $this->insertStepUser( $datos,  $step, $idFlow);
            //insertamos a la tabla de steps_steps
                $this->insertActionStepUser( $datos, $step, $idFlow);
            } 
        }
    }

    /**
     * Insert to the Table flow
     * @param array $datos
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
     * @param array $datos
     * @param array $steps
     * @param string $id_flow
     * @return String     
     */  
    protected function insertStep(array $datos,array $steps, $id_flow)
    {   
        $res= -1;
        foreach ($steps as $step) { 
            $identifier = "'". $step['id']."'";
            $description = "'". $step['description']."'";
            $axisY = ($step['axisY']== null)? 0 : $step['axisY'] ;
            $axisX =($step['axisX']== null)? 0 : $step['axisX'] ;
            DB::select("call insert_step($identifier, $id_flow, $description, $axisX, $axisY, @res)");   
            $res=DB::select("SELECT @res as res;");   
        }
        return json_decode(json_encode($res), true);
    }


    /**
     * Insert a row to the table StepStep
     * @param array $datos
     * @param object $step
     * @param string $id_flow
     * @return String     
     */  
    protected function insertStepStep(array $datos, array $step, $id_flow)
    {   $res = -1;
            //Falta validar los datos que esten que no este vacio etc
        $pasos = array_key_exists('steps', $step) ? $step['steps']: null;            
        if($pasos != null)
        foreach ($pasos as $paso) {
            $idInicial =  "'".$paso['begin']."'"; 
            $idFinal =  "'".$paso['end']."'";  
            $action =  $paso['action'];   //Validar que action exista cuando se pasa           
            if( $action != null){
                DB::select("call insert_step_step($idInicial, $idFinal, $id_flow, $action, @res)");
                $res=DB::select("SELECT @res as res;"); 
                if($res != 0)
                    return json_decode(json_encode($res), true);
            }                                        
        } 
        return json_decode(json_encode($res), true);
    }


    /**
     * Insert a row to the table StepUser
     * @param array $datos
     * @param object $step
     * @param string $id_flow
     * @return String     
     */  
    protected function insertStepUser(array $datos, array $step, $id_flow)
    {   
        $res = -1;
        //Falta validar los datos que esten que no este vacio etc
        $users = array_key_exists('users', $step) ? $step['users']: null;            
        if($users != null)
            foreach ($users as $user) {
                $step_id =  "'".$step['id']."'";   
                $username =  "'".$user['username']."'";      
                DB::select("call insert_step_user($step_id, $id_flow, $username, @res)");
                $res=DB::select("SELECT @res as res;");                                                              
            }     
        return json_decode(json_encode($res), true);
    }

     /**
     * Insert a row to the table StepUser
     * @param array $datos
     * @param object $step
     * @param string $id_flow
     * @return String     
     */  
    protected function insertActionStepUser(array $datos,array $step, $id_flow) {  
        $res = -1; 
        $actions = array_key_exists('actions', $step) ? $step['actions']: null;  // Actions on the step
        if($actions != null)
            foreach ($actions as $action) {
                $acciones = array_key_exists('actions', $action) ? $action['actions']: null;            
                if($acciones != null)            
                foreach ($acciones as $accion) {    
                    $step_id =  "'".$action['id']."'";   
                    $username =  "'".$action['username']."'";    
                    $accion = "'".$accion."'";   
                // $action =  $accion;   
                    DB::select("call insert_action_step_user($step_id, $id_flow, $username,$accion, @res)");
                    $res=DB::select("SELECT @res as res;");     
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
