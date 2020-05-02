<?php

namespace App\Http\Controllers;

use App\Classification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;

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

        $classification = Classification::all()->first();;
        return view('home.home', compact('classification'));
    }

    public function textEditor(){
        return view('textEditor.textEditor');
    }
}
