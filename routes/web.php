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

Auth::routes();

Route::get('textEditor',  function () {
    return view('textEditor/textEditor');
});


Route::resource('home', 'HomeController');

Route::get('ldap/obtenerUsuario', 'UserController@ldapGetUser' );

Route::get('home/{table}/{id}', 'HomeController@refresh');

Route::resource('roles', 'RoleController');

Route::resource('users', 'UserController');

Route::resource('flows', 'FlowController');

Route::resource('documents', 'DocumentController');

Route::resource('departments', 'DepartmentController');