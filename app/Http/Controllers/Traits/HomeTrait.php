<?php
namespace App\Http\Controllers\Traits;

//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Contracts\Encryption\DecryptException;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Action;
use App\Classification;
use App\Department;
use App\Flow;

trait HomeTrait{
    /**
     * Return home index
     *
     * @return \Illuminate\Http\Response
     * @param int $currentClassification
     */
    public function home() {
        $username = Auth::id();
        $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();
        $classifications = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 3]])->get();        
        $departments = Department::all();
        $flows  = Flow::where([['username', '=', '' . $username . ''],['state','=',1]])->get();;
        $actions = Action::where('type', '=', 1)->get();
        $myActions=['owner'];      
        $documents =  $mainClassification->documents;
        return view('home.home', compact('mainClassification','documents','classifications', 'flows','departments', 'actions','myActions'));
      }
}