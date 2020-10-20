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
use App\Document;
use App\Notification;
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
                return $this->refreshDocuments($currentClassification);
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

        $documents =  $mainClassification->documents;
        $notifications = Notification::where('username', '=', $username)->get();  
        return view('home.tableMyDocuments', compact('mainClassification', 'documents','classifications','myActions','notifications'));
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

        $notifications = Notification::where('username', '=', $username)->get();
        $idDocuments = array_column($mainClassification->documents->toarray(), 'id');

        $documents =  DB::table('action_document_user')->select('document_id')->whereIn('document_id', $idDocuments)->where('username', '=', '' . $username . '')->pluck('document_id')->toArray();
        $documents=Document::whereIn('id', $documents)->get();
        $mydocuments=$mainClassification->documents->where('username', $username);
        $documents= $documents->merge($mydocuments);
        return view('home.tableMyDocuments', compact('mainClassification','documents', 'classifications','myActions','notifications'));
    }

    /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param int $currentClassification
     */
    public function refreshDocuments($currentClassification)
    {
        $username = Auth::id();
        $myClassification = Classification::where('username', '=', '' . $username . '')->get();
        $Shareclassifications=DB::select("SELECT `classification_id`  FROM `action_classification_user` WHERE `username`=$username ");
        $Shareclassifications = json_decode(json_encode($Shareclassifications), true);
        $Shareclassifications=Classification::whereIn('id', $Shareclassifications)->get();    
        $Classifications=$myClassification->merge($Shareclassifications);
        $idDocuments =  DB::table('action_document_user')->select('document_id')->where('username', '=', '' . $username . '')->pluck('document_id')->toArray();
        $documents=Document::where('username', $username)->pluck('id')->toArray();
        $idDocuments=array_merge($documents,$idDocuments);
        $notifications = Notification::where('username', '=', $username)->get();
        $mainClassification=null;
        return view('home.tableDocuments', compact('mainClassification', 'Classifications','idDocuments','notifications'));
    }

    public function deletefiles($document)
    {
        $contents=DB::table('versions')->select('version','content')->where('document_id','=', $document)->pluck('content')->toArray();
        foreach ($contents as  $content) {        
            $file = storage_path('app/'.$content);
            File::delete($file);
            return true;
        }
        return false;
    }
}