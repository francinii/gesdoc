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
       date_default_timezone_set("UTC");
    } 

    public function getFileInfoAction($id,Request $request) {
        $dato=$request->all();
        $api_token=$dato['access_token'];
        $user=User::where('api_token',$api_token) -> first();
        $array = explode('-', $id);
        $id = (int) $array[0];
        $version = $array[1];
        $mode = $array[2]; // mode 1 home mode 2 flow
        $edit=$array[3]; //

        if($version=='last')
            $content=DB::table('versions')->select('version','content')->where('document_id','=', $id)->orderBy('version', 'desc')->pluck('content')->toArray();
        else
            $content=DB::table('versions')->select('version','content')->where([['document_id','=', $id],['version','=',$version]])->pluck('content')->toArray();

        $Document = Document::where([['id', '=', $id]])->first();
        $path = storage_path('app/'.$content[0]); 
        
        ($mode==1)?
        $actions=DB::table('action_document_user')->select('action_id')->where([['document_id','=', $id],['username','=',$user->username]])->pluck('action_id')->toArray():
        $actions=DB::table('action_step_user')->select('action_id')->where('username','=',$user->username)->pluck('action_id')->toArray();
       

        if((in_array(5,$actions)|| $Document->username==$user->username)&&$edit==1)
          $UserCanWrite=true;
        else if(in_array(4,$actions)||($Document->username==$user->username&&$mode=1))
           $UserCanWrite=false;
        else{
            http_response_code(404);
			header('X-WOPI-ServerError: Unable to find file / path is invalid');
			return;
        }
                

        if (file_exists($path)) {
            $name = $Document->description.'.'.$Document->type;
            $LastModifiedTime =  $Document->updated_at;
            $LastModifiedTime=$LastModifiedTime->addHour(6);
            $LastModifiedTime2=date("Y-m-d\TH:i:s.u\Z");
            $handle = fopen($path, "r");
            $size = filesize($path);
            $contents = fread($handle, $size);
            $SHA256 = base64_encode(hash('sha256', $contents, true));
            $json = array(
                'BaseFileName' => $name,
                'OwnerId' => $Document->username,
                'UserCanWrite' => $UserCanWrite,
                'SupportsUpdate' => true,
                'UserId'=> $user->username,
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

    public function putFile($id,Request $request) {
        $dato=$request->all();
        $api_token=$dato['access_token'];
        $user=User::where('api_token',$api_token) -> first();

        $array = explode('-', $id);
        $id = (int) $array[0];
        $version = $array[1];

        if($version=='last')
            $content=DB::table('versions')->select('version','content')->where('document_id','=', $id)->orderBy('version', 'desc')->pluck('content')->toArray();
        else
            $content=DB::table('versions')->select('version','content')->where([['document_id','=', $id],['version','=',$version]])->pluck('content')->toArray();


        $path = storage_path('app/'.$content[0]);
        $content=fopen('php://input', 'r');
        file_put_contents($path, $content);
        DB::select("call save_document($id,'$user->username',@res)");      
        $res = DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if ($res[0]['res'] != 0) {
            throw new DecryptException('error en la base de datos');
        }

        $Document = Document::where([['id', '=', $id]])->first();
        $data = array('status' => 'success');
        $LastModifiedTime =  $Document->updated_at;
        $LastModifiedTime=$LastModifiedTime->addHour(6);
        $data['LastModifiedTime'] = $LastModifiedTime;
        return $data;
    }
}
