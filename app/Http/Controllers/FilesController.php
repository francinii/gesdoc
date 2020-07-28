<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class FilesController extends Controller
{

    public function __construct()
    {
       //$this->middleware('auth');
    } 

    public function getFileInfoAction($name,Request $request) {

        $route='public/'.$name;
           
        $path = storage_path('app/'.$route);    
        $dato=$request->all();
        $username=$dato['access_token'];
        $user=User::where('username',$username) -> first();
         

        if (file_exists($path)) {
          //  $user = 
            $handle = fopen($path, "r");
            $size = filesize($path);
            $contents = fread($handle, $size);
            $SHA256 = base64_encode(hash('sha256', $contents, true));
            $json = array(
                'BaseFileName' => $name,
                'OwnerId' => 'admin',
                'UserCanWrite' => true,
                'SupportsUpdate' => true,
                'UserId'=> 'Fran',
                'Size' => $size,
                'SHA256' => $SHA256,             
                'UserFriendlyName'=> $user->name,
               // 'LastModifiedTime'=>date("Y-m-d\TH:i:s.u\Z"),
            );
            echo json_encode($json);
        } else {
            echo json_encode(array());
        }
    }

    public function getFileAction($name) {


 
       $route='public/'.$name;
       $path = storage_path('app/'.$route); 

        if (file_exists($path)) {
            $handle = fopen($path, "r");
            $contents = fread($handle, filesize($path));
            header("Content-type: application/octet-stream");
            echo $contents;
        }
    }

    public function putFile($name) {

       $route='public/'.$name;
       $path = storage_path('app/'.$route); 
       $content=fopen('php://input', 'r');

        file_put_contents($path, $content);
        $data = array('status' => 'success');
       // $data['LastModifiedTime'] = date("Y-m-d\TH:i:s.u\Z");
        return $data;
    }
}
