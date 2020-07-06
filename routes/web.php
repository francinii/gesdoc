<?php

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



Route::get('documents/textEditor',  function () {
    return view('documents/textEditor');
});

Route::get('documents/spreadSheetEditor',  function () {
    return view('documents/spreadSheetEditor');
});


Route::get('ldap/obtenerUsuario', 'UserController@ldapGetUser' );


Route::get('home/{table}/{id}', 'HomeController@refresh');
Route::post('home/share/classification/{id}', 'HomeController@Share');
Route::get('home/showshare/classification/{id}', 'HomeController@showShare');

Route::get('documents/showshare/document/{id}', 'DocumentController@showShare');
Route::get('documents/clone/{id}', 'DocumentController@clone');
Route::post('documents/share/document/{id}', 'DocumentController@Share');



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