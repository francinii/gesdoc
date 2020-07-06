<?php
namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use File;
use App\Action;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Classification;

trait RefreshHomeTrait{

      /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param int $table
     * @param int $currentClassification
     */

    public function refresh($table, $currentClassification)
    {
        switch ($table) {
            case '1':
                return $this->refreshMyDocuments($currentClassification);
                break;
            case '2':
                return $this->refreshShareDocuments($currentClassification);
                break;
            case '3':
                return $this->refreshDocumentsFlow($currentClassification);
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param int $currentClassification
     */
    public function refreshMyDocuments($currentClassification)
    {
        $username = Auth::id();
        if($currentClassification==0){
            $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 1]])->first();
            $myActions=['owner'];
        }            
        else{
            $mainClassification = Classification::where([['id', '=', $currentClassification]])->first();
            if($username==$mainClassification->username){
                $myActions=['owner'];
            }
            else{
                $myActions=DB::select("SELECT `action_id`  FROM `action_classification_user` WHERE `classification_id`=$currentClassification and `username`='$username'");

            }
        }
        if($mainClassification->type==3)
            $classifications=[];
        else
            $classifications = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 3]])->get();
        
           if($username)
            
        return view('home.tableMyDocuments', compact('mainClassification', 'classifications','myActions'));
    }

    /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param int $currentClassification
     */
    public function refreshShareDocuments($currentClassification)
    {
        $username = Auth::id();
        if($currentClassification==0){
            $mainClassification = Classification::where([['username', '=', '' . $username . ''], ['type', '=', 2]])->first();            
            $myActions=['owner'];
        }
        else{
            $mainClassification = Classification::where([['id', '=', $currentClassification]])->first();
            if($username==$mainClassification->username){
                $myActions=['owner'];
            }
            else{
                $myActions=DB::select("SELECT `action_id`  FROM `action_classification_user` WHERE `classification_id`=$currentClassification and `username`='$username'");

            }
        }
        if($mainClassification->type==3)
            $classifications=[];
        else{
            $classifications=DB::select("SELECT `classification_id`  FROM `action_classification_user` WHERE `username`=$username ");
            $classifications = json_decode(json_encode($classifications), true);
            $classifications=Classification::whereIn('id', $classifications)->get();
        }
        return view('home.tableMyDocuments', compact('mainClassification', 'classifications','myActions'));
    }

    /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param int $currentClassification
     */
    public function refreshDocumentsFlow($currentClassification)
    {
            /*$username = Auth::id();
        $classification = Classification::where([['id', '=',$currentClassification]])->first();
        $allClassifications=Classification::where([['username', '=',''.$username.''],['is_start', '=',true]])->first();
        $allClassifications=$this->classifications($allClassifications);
        return view('home.tableDocumentsFlow', compact('classification','allClassifications'));*/
    }

    public function deletefiles($document)
    {
        $contents=DB::table('versions')->select('version','content')->where('document_id','=', $document)->whereNull('flow_id')->pluck('content')->toArray();
      foreach ($contents as  $content) {        
        $file = storage_path('app/'.$content);
        File::delete($file);
      }
    }
}