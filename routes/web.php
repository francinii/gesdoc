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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('ldap/obtenerUsuario', 'ldapController@ldapObtenerUsuario' );

//Route::get('/rols', 'RolController@index');
//Accede a todas las rutas necesarioas para acceder a los metodos del controlador
Route::resource('rols', 'RolController');
