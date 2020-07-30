<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Document;
use Auth;
use DB;
use App\User;

class FilesController extends Controller
{

    public function __construct()
    {
       //$this->middleware('auth');
    } 

    public function getFileInfoAction($id,Request $request) {
        $array = explode('-', $id);
        $id = (int) $array[0];
        $version = $array[1];

        $content=DB::table('versions')->select('version','content')->where('document_id','=', $id)->orderBy('version', 'desc')->pluck('content')->toArray();
        $Document = Document::where([['id', '=', $id]])->first();
        $path = storage_path('app/'.$content[0]); 
          
        $dato=$request->all();
        $api_token=$dato['access_token'];
        $user=User::where('api_token',$api_token) -> first();


        if (file_exists($path)) {
            $name = $Document->description.'.'.$Document->type;
            $LastModifiedTime = $Document->updated_at;
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
                'LastModifiedTime'=>$LastModifiedTime,
            );
            echo json_encode($json);
        } else {
            echo json_encode(array());
        }
    }

    public function getFileAction($id) { 

        $content=DB::table('versions')->select('version','content')->where('document_id','=', $id)->orderBy('version', 'desc')->pluck('content')->toArray();
        $path = storage_path('app/'.$content[0]); 

        if (file_exists($path)) {
            $handle = fopen($path, "r");
            $contents = fread($handle, filesize($path));
            header("Content-type: application/octet-stream");
            echo $contents;
        }
    }

    public function putFile($id) {

       $content=DB::table('versions')->select('version','content')->where('document_id','=', $id)->orderBy('version', 'desc')->pluck('content')->toArray();
       $path = storage_path('app/'.$content[0]); 
       $Document = Document::where([['id', '=', $id]])->first();
       $content=fopen('php://input', 'r');
       $LastModifiedTime = $Document->updated_at;
        file_put_contents($path, $content);
        $data = array('status' => 'success');
        $data['LastModifiedTime'] = $LastModifiedTime;
        return $data;
    }
}
