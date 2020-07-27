<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//require 'vendor/autoload.php';
//use Pux\Mux;
//use Pux\Executor;
use Auth;


class FilesController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
    } 

    public function getFileInfoAction($name) {
     //   $path = "office/$name";
        $route='public/'.$name;
       // $path = storage_path('app/'.$route);    
        $path = storage_path('app/'.$route);    
     //   $path = "C:\wamp\www\gesdoc/resources/extensions/WopiHost/office/test.docx";
     

        if (file_exists($path)) {
          //  $user = Auth::user()->username;
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
                'UserFriendlyName'=>'Danny',
                'LastModifiedTime'=>date("Y-m-d\TH:i:s.u\Z"),
            );
            echo json_encode($json);
        } else {
            echo json_encode(array());
        }
    }

    public function getFileAction($name) {


       // $path = "office/$name";
       $route='public/'.$name;
       $path = storage_path('app/'.$route); 
      // $path = "C:\wamp\www\gesdoc/resources/extensions/WopiHost/office/test.docx";
        if (file_exists($path)) {
            $handle = fopen($path, "r");
            $contents = fread($handle, filesize($path));
            header("Content-type: application/octet-stream");
            echo $contents;
        }
    }

    public function putFile($name) {

      // $path = "office/$name";
       $route='public/'.$name;
       $path = storage_path('app/'.$route); 
      // $path = "C:\wamp\www\gesdoc/resources/extensions/WopiHost/office/test.docx";

       // $content=fopen('php://input', 'r');
      // $content = file_get_contents('php://input');

        file_put_contents($path, $content);

        if(!($content=fopen('php://input', 'r'))){
            throw new Exception("Can't get PUT data.");

        }

    }
}
/*

$mux = new Mux;


$mux->get('/files/:name', ['FilesController','getFileInfoAction']); //CheckFileInfo 

$mux->get('/files/:name/contents', ['FilesController','getFileAction']); // GetFile

$mux->post('/files/:name/contents', ['FilesController','putFile']); // PutFile

//$path = $_SERVER['PATH_INFO'];
$path = '/files/test.docx';
$args = explode("&", $path);

$route = $mux->dispatch( $args[0] );
Executor::execute($route); */