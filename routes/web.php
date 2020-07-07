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


Route::get('/main', 'HomeController@index')->name('main');

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login.form');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::get('/home', function () {
    return redirect('main');
})->name('home');

Route::group(['middleware'=>['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/pass', 'HomeController@UpdatePass')->name('home.pass');
    Route::get('/dashboard', 'DashboardController')->name('dashboard');

    //Rutas de administradores
    Route::group(['middleware'=>['Administrador']],function(){

        //Rutas Usuarios
        Route::get('/usuario', 'UserController@index')->name('user.lista');
        Route::post('/usuario/registrar', 'UserController@store')->name('usuario.registrar');
        Route::put('/usuario/actualizar', 'UserController@update')->name('usuario.actualizar');
        Route::put('/usuario/activar', 'UserController@activar')->name('usuario.activar');
        Route::put('/usuario/desactivar', 'UserController@desactivar')->name('usuario.desactivar');

        //Ruta Pedidos
        Route::get('/pedidos', 'PedidosController@index')->name('pedidos.lista');
        Route::post('/pedido/registrar', 'PedidosController@store')->name('pedido.registrar');
        Route::get('/pedido/obtenerPedido', 'PedidosController@obtenerPedido')->name('pedido.obtenerPedido');

        //Obtener Direcciones Tercero
        Route::get('/direcciones/tercero', 'DireccionesController@ObtenerDireccionesTercero')->name('direcciones.tercero');

        
    });

    Route::group(['middleware'=>['Usuario']],function(){

    });

    Route::group(['middleware'=>['UsuarioExt']],function(){
         //Ruta Pedidos
         Route::get('/pedidos', 'PedidosController@index')->name('lista');
         Route::post('/pedido/registrar', 'PedidosController@store')->name('pedido.registrar');
         Route::get('/pedido/obtenerPedido', 'PedidosController@obtenerPedido')->name('pedido.obtenerPedido');
    });

    //Obtener productos lista de precios tercero
    Route::get('/listaprecios/lista', 'HomeController@ObtenerDetallesListaPrecios')->name('listaprecios.lista');
    Route::get('/listaprecios/lista2', 'HomeController@ObtenerDetallesListaPreciosprueba')->name('listaprecios.lista2');
});

