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
//Accede a todas las rutas necesarioas para obtener los metodos del RolController
Route::resource('rols', 'RolController');



// Por confirmar la ruta de post es necesaria cuando de un formulario se usa un metodo post
// Fue la unica manera en que me funco el formulario cuando hacia la redirección
Route::post('rols', 'RolController@index');