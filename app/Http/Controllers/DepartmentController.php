<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
class DepartmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Department Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the departments' resources. That 
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
        // $roles = Role::all();
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

        /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function refresh()
    {
        $departments = Department::all();
        return view('departments.table', compact('departments'));
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
            'description' => ['required', 'string', 'max:255'],
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
        $dato = request()->except(['_token']);

        Department::insert($dato);        
        return DepartmentController::refresh();
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
        $this->validator($request->all())->validate();
        $dato = request()->except(['_token','_method']);
        $id = $dato['id'];
        Department::where('id', '=', $id)->update($dato);
        return DepartmentController::refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::destroy($id);
        return DepartmentController::refresh();
    }
}
