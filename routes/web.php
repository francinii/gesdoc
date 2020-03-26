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
        return view('home');
    }
    else{
        return view('auth/login');
    }
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('ldap/obtenerUsuario', 'UserController@ldapGetUser' );

//Route::get('/register_user', 'Auth\RegisterController@index' );

//Route::get('/rols', 'RolController@index');
//Accede a todas las rutas necesarioas para
// obtener los metodos del RolController
Route::resource('roles', 'RoleController');


Route::resource('users', 'UserController');

Route::resource('flows', 'FlowController');

Route::resource('documents', 'DocumentController');

Route::resource('departments', 'DepartmentController');