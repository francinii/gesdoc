<?php

use Pux\Mux;
use Pux\Executor;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    else{
        return view('auth/login');
    }
    
});



Route::get('ldap/obtenerUsuario', 'UserController@ldapGetUser' );


Route::get('home/{table}/{id}', 'HomeController@refresh');
Route::post('home/share/classification/{id}', 'HomeController@Share');
Route::get('home/showshare/classification/{id}', 'HomeController@showShare');

Route::get('documents/showshare/document/{id}', 'DocumentController@showShare');
Route::get('documents/clone/{id}', 'DocumentController@clone');
Route::post('documents/share/document/{id}', 'DocumentController@Share');
Route::get('documents/open/{id}', 'DocumentController@openDocument');



Route::get('documentFlow/historial/{id}', 'DocumentFlowController@historial');
Route::get('documentFlow/preview/{id}', 'DocumentFlowController@preview');
Route::get('documentFlow/historial/panel/{id}', 'DocumentFlowController@openPanel');
Route::get('documentFlow/nextVersion/{id}', 'DocumentFlowController@nextVersion');

//notesModal
Route::get('documentFlow/notesModal/{id}', 'DocumentFlowController@listNotesModal');

//notesModal
Route::get('documentFlow/modalEditVersion/{id}', 'DocumentFlowController@modalEditVersion');
Route::get('documentFlow/flowProcess/{id}', 'DocumentFlowController@flowProcess');
Route::get('documentFlow/location/{id}', 'DocumentFlowController@location');
Route::get('documentFlow/editionMode/{id}', 'DocumentFlowController@editionMode');


//flow/active/
Route::get('flow/clone/{id}', 'FlowController@clone');
Route::get('flow/active/{id}', 'FlowController@activeFlow');
//Route::get('flow/refresh/', 'FlowController@refresh');
Route::get('flow/permission/{id}', 'FlowController@permissionModal');
Route::get('flow/permissionTable/{id}', 'FlowController@permissionTable');
Route::get('flow/savePermissionsModal/{id}', 'FlowController@savePermissionsModal');

Route::resource('userDocFlow', 'UserDocFlowController');

Auth::routes();

Route::resource('home', 'HomeController');

Route::resource('roles', 'RoleController');

Route::resource('users', 'UserController');

Route::resource('flows', 'FlowController');

Route::resource('documents', 'DocumentController');

Route::resource('departments', 'DepartmentController');


Route::resource('documentFlow', 'DocumentFlowController');


Route::resource('record', 'HistorialController');




//Routes for the Wopi Host
Route::get('wopi/files/{name}', 'FilesController@getFileInfoAction'); //CheckFileInfo 
Route::post('wopi/files/{name}/contents', 'FilesController@putFile'); // PutFile
Route::get('wopi/files/{name}/contents', 'FilesController@getFileAction'); // GetFile


