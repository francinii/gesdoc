<?php

namespace App\Http\Controllers;

use App\Flow;
use App\User;
use App\Department;
use App\Action;
use App\Step;
use App\StepStep;
use App\StepUser;
use App\ActionStepUser;
use DB;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


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
    public function __construct()
    {
        $this->middleware('auth');
    }


    const DRAGGABLE_FINAL = "draggable_final";
    const DRAGGABLE_INICIO = "draggable_inicio";

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
        $actions = Action::all();
        $filterActions = Action::where('type','=', 1)->orWhere('type','=', 0)->get();
        return view('Flows.index',compact('flows', 'users','departments','actions','filterActions'));
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
     * Display the specified resource.
     *
     * @param  \App\Flow  $flow
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = request()->except(['_token']);  
        $id_flow = $data['id'];
        $flow =Flow::find($id_flow);
        $steps = $flow->steps;   
        $step_step = StepStep::where('prev_flow_id', '=', $id_flow)
            ->join('actions', 'actions.id', '=', 'step_step.id_action')
            ->get();
        $action_step_user = 
        ActionStepUser::where('flow_id', '=', $id_flow)
            ->join('users', 'users.username', '=', 'action_step_user.username')
            ->join('actions', 'actions.id', '=', 'action_step_user.action_id')
            ->get();
        $users = User::all();
      return compact('flow','step_step','users', 'action_step_user');
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
        $data = request()->except(['_token', '_method']);        
       // Flow::destroy($id);        
        $res= $this->insertFlow($data);
        $idFlow = $res[0]['id_flow'] ;
        $this->insert( $data, $idFlow);
    
      return $this->refresh();
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
        $usuario = Auth::user()->username;
        $flows =Flow::where('username', '=', $usuario)->get();
        $users = User::all();
        $departments = Department::all();
        $actions = Action::all();
        $filterActions = Action::where('type','=', 1)->orWhere('type','=', 0)->get();
        return view('flows.table',compact('flows', 'users','departments','actions', 'filterActions'));
    }


    /**
     * Insert to the entire process of a flow (flow, step, stepsteps, stepusers, actionstepuser)
     * @param array $datos
     * @param string $id_Flow   
     */  
    protected function insert(array $datos, $id_Flow)
    {   
        $idFlow =   (int) $id_Flow;  
        $steps = json_decode(json_encode( $datos['data']), true);
        if($steps != null){
            //insertamos a la tabla de steps Es necesario que se agreguen los 
            //steps antes de ingresar datos a las otras tablas
            $this->insertStep($steps, $idFlow);
        
            foreach ($steps as $step) {                  
            //insertamos a la tabla de steps_steps
            if($step != null){
                  $this->insertStepStep($step, $idFlow);
                //insertamos a la tabla de steps_users
                //$this->insertStepUser( $datos,  $step, $idFlow);
                //insertamos a la tabla de action_step_user
                $this->insertActionStepUser($step, $idFlow);
            }
              
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
        $id = $datos['id'];
        $username = "'".$datos['username']."'";  
        $description = "'".$datos['description']."'"; 
        $state = 0; 
            if($id == '')
                DB::select("call insert_flow($username, $description,$state, @res, @id_flow)");
            else 
                DB::select("call update_flow($id, $username, $description, $state, @res, @id_flow)");

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
    protected function insertStep(array $steps, $id_flow)
    {   
        $res= -1;
        //Delete the steps asociated to a flow
        DB::select("call delete_steps($id_flow, @res)");                  
        foreach ($steps as $step) { 
            if($step !=null){
                $identifier = "'". $step['id']."'";
                $description = "'". $step['description']."'";
                $axisY = ($step['axisY']== null)? 0 : $step['axisY'] ;
                $axisX =($step['axisX']== null)? 0 : $step['axisX'] ;
                DB::select("call insert_step($identifier, $id_flow, $description, $axisX, $axisY, @res)");   
                $res=DB::select("SELECT @res as res;");   
            }            
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
    protected function insertStepStep(array $step, $id_flow)
    {   
        $actions = Action::where('type', '=', 2)->get();
        $actionid = $actions[0]['id'];
        $res = -1;

         //Delete the steps asociated to a flow
         DB::select("call delete_steps_steps($id_flow, @res)");  
            //Falta validar los datos que esten que no este vacio etc
        $steps = array_key_exists('steps', $step) ? $step['steps']: null;            
        if($steps != null)
            foreach ($steps as $paso) {
                if($paso !=null && array_key_exists('begin', $paso) && array_key_exists('end', $paso) && array_key_exists('action', $paso)){
                    $idInicial =  "'".$paso['begin']."'"; 
                    $idFinal =  "'".$paso['end']."'";  
                    $action = $paso['begin'] == self::DRAGGABLE_INICIO?   $actionid : $paso['action'];
            // $action =  $paso['action'] != ''?  "'".$paso['action']."'" : "'1'";   //Validar que action exista cuando se pasa           
                    if( $action != null){
                        DB::select("call insert_step_step($idInicial, $idFinal, $id_flow, $action, @res)");
                        $res=DB::select("SELECT @res as res;"); 
                        //$res = json_decode(json_encode($res), true);
                        //if($res[0]['res'] != 0)
                       // return json_decode(json_encode($res), true);
                    }  
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
    protected function insertActionStepUser(array $step, $id_flow) { 

        $users =  array_key_exists('users', $step) ?  $step['users']: null;    
        $res = -1; 
        $step_id = "'". $step['id']."'";
        //Delete the steps asociated to a flow
        DB::select("call delete_steps_steps($id_flow, @res)"); 
        if($users != null){                   
            foreach ($users as $user) {   
                $username =  "'".$user['username']."'";   
                $actions = array_key_exists('actions', $user) ? $user['actions']: null;  // Actions on the step   
                if($actions != null)
                    foreach ($actions as $action) {        
                        if($action !=null){    
                                          
                            DB::select("call insert_action_step_user($step_id, $id_flow, $username,$action, @res)");
                            $res=DB::select("SELECT @res as res;");   
                        }                                            
                    }
            }
        }
        return json_decode(json_encode($res), true);
    }



    protected function activeFlow(Request $request){
        $data = request()->except(['_token']);  
        $id_flow = (int) $data['idFlow']; 
        $active =  (int) $data['active']; 
        DB::select("call active_flow($id_flow, $active, @res)");
                            $res=DB::select("SELECT @res as res;");   
        //Procedimiento activar o desactivar
      return $this->refresh();
    }

    protected function permissionModal(Request $request){
        $identifier = null;
        $data = request()->except(['_token']);  
        $flowId = (int) $data['idFlow']; 
        if(array_key_exists('identifier', $data)){
            $identifier =  $data['identifier']; 
        }
        $allusers = User::all();
        $departments = Department::all();
        $steps = Step::where('flow_id', '=', $flowId)->get();                    
        $flow= Flow::where('id', '=', $flowId)->first();
        $actions = Action::all();
        //get the flow element
            $step = Step::where('flow_id', '=', $flowId)
            ->where('id', '!=', 'draggable_inicio')
            ->where('id', '!=', 'draggable_final')
            ->first();
            
            //$step = Step::where('flow_id', '=', $flowId)->first();
            $actionStepUser = ActionStepUser::where('flow_id', '=', $flowId)->where('step_id', '=', $step->id)->get(); 

            $usersArray = ActionStepUser::where('flow_id', '=', $flowId)->where('step_id', '=', $step->id)->pluck('username')->toArray();
            $users = User::whereIn('username', $usersArray)->get();
            return view('flows.permission',compact('flow', 'users','actionStepUser','actions', 'steps','step','allusers', 'departments','usersArray'));
    }


    protected function permissionTable(Request $request){
       
        $data = request()->except(['_token']);  
        return $this->refreshTablePermission($data);
        
    }   


    protected function refreshTablePermission($data){
        $identifier = null;
        $flowId = (int) $data['idFlow']; 
        if(array_key_exists('identifier', $data)){
            $identifier =  $data['identifier']; 
        }
        $allusers = User::all();
        $departments = Department::all();
        $steps = Step::where('flow_id', '=', $flowId)->get();                    
        $flow= Flow::where('id', '=', $flowId)->first();
        $actions = Action::where('type','=', 1)->orWhere('type','=', 0)->get();
        $step = Step::where('flow_id', '=', $flowId)->where('id', '=', $identifier)->first();    
        
        $usersArray = ActionStepUser::where('flow_id', '=', $flowId)
        ->where('step_id', '=', $identifier)->pluck('username')->toArray();
        $users = User::whereIn('username', $usersArray)->get();

        $actionStepUser = ActionStepUser::where('flow_id', '=', $flowId)
        ->where('step_id', '=', $identifier)
        ->orderBy('action_id', 'ASC')->get(); 

        return view('flows.permissionTable',compact('flow', 'users','actionStepUser','actions', 'steps','step','allusers','departments','usersArray'));
       

    }

    protected function savePermissionsModal(Request $request){
        $auxUserArray = [];
        $data = request()->except(['_token']);  
        $flowId = (int) $data['idFlow'];      
        $identifier = $data['identifier'] ; 
        $actionStepUser =  $data['actionStepUser'];  
        $count = 0;   
        
        foreach ($actionStepUser as $asu) { 
            $username =   $asu[0] ;         
            array_push($auxUserArray,$username);
            $identifier =$data['identifier'] ; 

            //Get an arrat of actions from the DB
            $actionsArray = ActionStepUser::where('flow_id', '=', $flowId)
            ->where('step_id', '=', $identifier)
            ->where('username', '=', $username)
            ->pluck('action_id')->toArray(); 
            

            //Fin which elements are not in the html table
            $direfenceArray  =array_diff($actionsArray, $asu);
            $identifier1 ="'". $data['identifier'] . "'" ; 
            $username1 = "'".$username . "'";  

            //Delete the elements in the database
            foreach ($direfenceArray as $act) {
                $action =  $act;                              
                DB::select("call delete_an_action_step_user($flowId,$identifier1,$username1,$action, @res)");
                $res=DB::select("SELECT @res as res;");   
            }

            //Add the new elements to the database
            foreach ($asu as $act) {                  
                if($count>0){
                    $action = (int) $act;
                    DB::select("call insert_update_action_step_user($identifier1, $flowId, $username1,$action, @res)");
                    $res=DB::select("SELECT @res as res;");   
                }
                $count++;
            }
            $count =0;
        }

        // IN case of user is delete completly from the html table
        
        $usersArray = ActionStepUser::where('flow_id', '=', $flowId)
        ->where('step_id', '=', $identifier)
        ->groupBy('username')
        ->pluck('username')->toArray();  
        $direfenceArray  =array_diff($usersArray, $auxUserArray);
        foreach ($direfenceArray as $user) {
            $username1 =  "'".$user . "'";  
                                   
            DB::select("call delete_action_step_user_by_user($flowId,$identifier1,$username1, @res)");
            $res=DB::select("SELECT @res as res;");   
        }


        return $this->refreshTablePermission($data);
    }
    
}
