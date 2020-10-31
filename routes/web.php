<?php

use Illuminate\Support\Facades\Route;

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
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/proveedor','ProveedorController');

Route::resource('/cliente','ClienteController');

Route::resource('/gestion','GestionController');

Route::get('/mes/gestion/{gestion}','MesController@index_por_gestion')->name('mes.gestion');
Route::get('/mes/gestion/create/{gestion}','MesController@createMes')->name('mes.create.mes');

Route::resource('/mes','MesController');
Route::delete('/mes/destroyForce/{mes}','MesController@destroyForce')->name('mes.destroyForce');


Route::get('/compra/mes/{mes}','CompraController@lista_por_mes')->name('compra.mes');
Route::get('/compra/mes/create/{mes}','CompraController@createCompra')->name('compra.create.mes');
Route::get('/compra/pdf_carta/{mes}','CompraController@generarPDFcarta')->name('compra.pdf.carta');
Route::get('/compra/pdf_oficio/{mes}','CompraController@generarPDFoficio')->name('compra.pdf.oficio');
Route::get('/compra/excel/{mes}','CompraController@generarExcel')->name('compra.excel');
Route::delete('/compra/destroy/{mes}','CompraController@destroyAll')->name('compra.destroyAll');

Route::resource('/compra','CompraController');

Route::get('/venta/mes/{mes}','VentaController@lista_por_mes')->name('venta.mes');
Route::get('/venta/mes/create/{mes}','VentaController@createventa')->name('venta.create.mes');
Route::get('/venta/pdf_carta/{mes}','VentaController@generarPDFcarta')->name('venta.pdf.carta');
Route::get('/venta/pdf_oficio/{mes}','VentaController@generarPDFoficio')->name('venta.pdf.oficio');
Route::get('/venta/excel/{mes}','VentaController@generarExcel')->name('venta.excel');
Route::delete('/venta/destroy/{mes}','VentaController@destroyAll')->name('venta.destroyAll');

Route::resource('/venta','VentaController');

Route::get('/config/{user}','UserController@show')->name('user.config');
