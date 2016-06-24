<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/autorizar', ['as' => 'autorizar', function (){
	 return view('autorizaciones.autorizaciones_retiro');
}]);

Route::get('/autorizar/id', ['as' => 'autorizar_retiro', function (){
	 return view('autorizaciones.autorizar_retiro');
}]);

Route::get('/salidas', ['as' => 'salidas', function (){
	 return view('salidas.salidas');
}]);

Route::get('/movimientos', array('as' => 'movimientos', 'uses' => 'MovimientosController@index' ));

Route::get('/articulos', array('as' => 'articulos', 'uses' => 'ArticulosController@index' ));

Route::get('rubros', function () {      
	$rubros=DB::table('rubros')
		->select('id_rubro AS id', 'descripcion AS text' )
		->get();
    return Response::json($rubros);
});

Route::get('rubrosub/id={id}', function ($id) {    
	$rubrosub=DB::table('subrubros')
		->where('id_rubro', '=', $id )
		->select('id_subrubro AS id', 'descripcion AS text' )
		->get();
    return Response::json($rubrosub);
});

Route::get('subrubros', function () {    
	$subrubros=DB::table('subrubros')
		->select('id_subrubro AS id', 'descripcion AS text' )
		->get();
    return Response::json($subrubros);
});

Route::get('/movimientos/responsables', function () {    
	$responsable=DB::table('empleados')
		->select('id_empleado AS id', 'apellido AS text' )
		->where('responsable', '=', 1)
		->get();
    return Response::json($responsable);
});

Route::get('/movimientos/empleados', function () {    
	$empleados=DB::table('empleados')
		->select('id_empleado AS id', 'apellido AS text' )
		->where('responsable', '=', 0)
		->get();
    return Response::json($empleados);
});

Route::get('/movimientos/articulos', function (Illuminate\Http\Request  $request) {
    $term = $request->term ?: '';
    $tags = App\articulos::where('descripcion', 'like', $term.'%')
	    ->select('descripcion AS text', 'id_articulo AS id', 'stock_actual', 'unidad')
	    ->get()
	    ->toJson();
    return $tags;
});

Route::post('/articulos/addarticulo', ['as' => 'addarticulos', 'uses' => 'ArticulosController@store']);

Route::post('/articulos/dardebaja', ['as' => 'dardebaja', 'uses' => 'ArticulosController@baja']);

Route::post('/articulos/edit', ['as' => 'edit', 'uses' => 'ArticulosController@edit']);

Route::post('/movimientos/addsalida', ['as' => 'addsalida', 'uses' => 'MovimientosController@store']);

Route::controller('datatables', 'DatatablesController', [
    'anyData'  => 'datatables.data',
    'getIndex' => 'datatables',
]);

