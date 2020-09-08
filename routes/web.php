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
    //Se crea ruta login por method get para que no genere error y redirija al formulario
    Route::get('/login','Auth\LoginController@showLoginForm' )->name('login');
});

Route::get('/home', function () {
    return redirect('main');
})->name('home');

Route::group(['middleware'=>['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/pass', 'HomeController@UpdatePass')->name('home.pass');
    Route::get('/dashboard', 'DashboardController')->name('dashboard');
    Route::get('/pdf', 'PdfController@invoice');

    //Rutas de administradores
    Route::group(['middleware'=>['Administrador']],function(){

        //Rutas Usuarios
        Route::get('/usuario', 'UserController@index')->name('user.lista');
        Route::post('/usuario/registrar', 'UserController@store')->name('usuario.registrar');
        Route::put('/usuario/actualizar', 'UserController@update')->name('usuario.actualizar');
        Route::put('/usuario/activar', 'UserController@activar')->name('usuario.activar');
        Route::put('/usuario/desactivar', 'UserController@desactivar')->name('usuario.desactivar');
        Route::get('/usuario/datosusr', 'UserController@ObtenerUsuario')->name('user.data');

        //Ruta Pedidos
        Route::get('/pedidos', 'PedidosController@index')->name('pedidos.lista');
        Route::post('/pedido/registrar', 'PedidosController@store')->name('pedido.registrar');
        Route::get('/pedido/obtenerPedido', 'PedidosController@obtenerPedido')->name('pedido.obtenerPedido');
        Route::delete('/pedido/eliminardet', 'PedidosController@EliminarDetallePedido')->name('pedido.eliminarDet');
        Route::put('/pedido/actualizar', 'PedidosController@update')->name('pedido.actualizar');
        Route::get('/pedidos/imprimir', 'PedidosController@ImprimirPedido')->name('pedidos.imprimir');


        //Obtener Direcciones Tercero
        Route::get('/direcciones/tercero/{Id?}', 'DireccionesController@ObtenerDireccionesTercero')->name('direcciones.tercero');

        Route::get('/reporte/ventas', 'ReportesController@ReporteVentas')->name('reporte.ventas');
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

    //Rutas Terceros
    Route::get('/terceros/ObtenerTerceros', 'TercerosController@ObtenerClientes')->name('terceros.lista');

    //Rutas Documentos
    Route::get('/documentos/ObtenerDocTp', 'DocumentosController@ObtenerDocumentosTp')->name('documentos.obtenertp');

    //Rutas Movimientos
    Route::get('/movimientos', 'MovimientosController@index')->name('movimientos.lista');
    Route::get('/movimiento/obtenerMovimiento', 'MovimientosController@obtenerMovimiento')->name('movimiento.obtenerMovimiento');

    //Notificaciones
    Route::post('/notification/get', 'NotificationController@get')->name('notifications');
    Route::get('/notification/leer', 'UserController@LeerNotificaciones')->name('notifications.read');

    //Rutas campos de formularios
    Route::get('/asesores/lista', 'HomeController@CargarAsesores')->name('asesores.lista');
    Route::get('/conceptos/lista/{IdDoc}', 'HomeController@CargarConceptosDocumentos')->name('conceptos.lista');

    //Configuraciones Documentos
    Route::post('/documentos/GuardarConfig', 'DocumentosController@GuardarCampoConfiguracion')->name('config.save');
    Route::get('/documentos/campos', 'DocumentosController@CargarCamposconfiguracion')->name('campos.lista');
    Route::put('/documentos/campos/delete', 'DocumentosController@EliminarCampoconfiguracion')->name('campos.delete');

});

