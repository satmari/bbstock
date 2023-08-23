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
use App\bbStock;

Route::get('/', 'mainController@index');
Route::get('/home', 'mainController@index');

Route::get('inteosdb', 'inteosdbController@index');
Route::get('inteosdb/create', 'inteosdbController@create');
//Route::get('inteosdb/{id}', 'inteosdbController@show');
Route::post('inteosdb', 'inteosdbController@create');

Route::post('inteosdb/create', 'bbstockController@create');
Route::get('bbstock', 'bbstockController@index');
Route::get('bbstock/create', 'bbstockController@create');
//Route::get('bbstock/remove', 'bbstockController@remove');
Route::get('bbstock/{id}', 'bbstockController@show');
Route::get('bbstock/{id}/edit', 'bbstockController@edit');
Route::post('bbstock', 'bbstockController@create');
Route::post('bbstock/create', 'bbstockController@create');
Route::patch('bbstock/{id}', 'bbstockController@update');
Route::get('bbstock/{id}/delete', 'bbstockController@delete');
Route::get('bbstock/{id}/delete_pallet', 'bbstockController@delete_pallet');

// add more bb
Route::get('addmorebb', 'addmorebbController@index');
Route::post('set_to_add', 'addmorebbController@set_to_add');
Route::post('addbbloc', 'addmorebbController@addbbloc');
Route::post('addbbsave', 'addmorebbController@addbbsave');
//Route::resource('bbstock', 'bbstockController');

Route::get('removebb', 'removebbController@index');
Route::get('removebb/destroy', 'removebbController@destroy');
Route::post('removebb/destroy', 'removebbController@destroy');
Route::get('removebb/destroybb', 'removebbController@destroybb');
Route::post('removebb/destroybb', 'removebbController@destroybb');
Route::get('removebb_choose/{id}', 'removebbController@removebb_choose');

Route::get('search', 'searchController@index');
Route::post('search', 'searchController@search');
Route::get('search2', 'searchController@index2');
Route::post('search2', 'searchController@search2');
Route::get('searchbypo', 'searchController@searchbypo');
Route::post('searchbypo', 'searchController@searchbypopost');
Route::get('searchbybb', 'searchController@searchbybb');
Route::post('searchbybb', 'searchController@searchbybbpost');

Route::get('export', 'exportController@create');

Route::get('home', 'HomeController@index');

Route::get('map', 'mapController@index');
Route::get('map/{id}', 'mapController@showbygroup');
Route::get('table', 'mapController@table');
Route::get('tablelog', 'mapController@tablelog');
Route::get('bundlelog', 'mapController@bundlelog');
Route::get('deliveredlog', 'mapController@deliveredlog');

//Status
Route::get('status', 'statusController@index');
Route::get('status/find', 'statusController@find');
Route::post('find_by_status', 'statusController@find_by_status');

// Workstudy
Route::get('workstudy', 'workstudyController@index');
Route::post('scan_bb', 'workstudyController@scan_bb');
Route::post('workstudy/create', 'workstudyController@create');

// Transit
Route::get('transitbb', 'transitController@index');
Route::post('transitloc', 'transitController@transitloc');
Route::post('set_to_transit', 'transitController@set_to_transit');
Route::post('addbb_to_transit', 'transitController@addbb_to_transit');
Route::post('remove_to_transit', 'transitController@remove_to_transit');

// Pallet
Route::get('select_pallet', 'palletController@select_pallet');
Route::post('select_pallet_confirm', 'palletController@select_pallet_confirm');
Route::post('select_location_confirm', 'palletController@select_location_confirm');


/*
Route::get('transitbb', 'transitController@index');
Route::post('transitloc', 'transitController@transitloc');
Route::post('set_to_transit', 'transitController@set_to_transit');
Route::post('addbb_to_transit', 'transitController@addbb_to_transit');
Route::post('remove_to_transit', 'transitController@remove_to_transit');
*/

// Load // UnLoad
Route::get('loadbb', 'loadController@index');
Route::post('loadloc', 'loadController@loadloc');
Route::post('set_to_load', 'loadController@set_to_load');
Route::post('addbb_to_load', 'loadController@addbb_to_load');
Route::post('remove_to_load', 'loadController@remove_to_load');
Route::get('unloadbb', 'loadController@index_unload');
Route::post('unloadloc', 'loadController@unloadloc');
Route::post('unloadloc_confirm', 'loadController@unloadloc_confirm');

// Load new
Route::get('loadbbt', 'loadtruckController@index');
Route::post('loadloct', 'loadtruckController@loadloct');
Route::post('set_to_loadt', 'loadtruckController@set_to_loadt');
Route::post('remove_to_loadt', 'loadtruckController@remove_to_loadt');
Route::post('addbb_to_loadt', 'loadtruckController@addbb_to_loadt');
Route::post('addbb_to_loadt_complete', 'loadtruckController@addbb_to_loadt_complete');
Route::get('unloadbbt', 'loadtruckController@index_unloadt');
Route::post('unloadloct', 'loadtruckController@unloadloct');
Route::post('unloadloc_confirmt', 'loadtruckController@unloadloc_confirmt');

// Production
Route::get('production', 'productionController@index');
Route::get('deliver/{username}', 'productionController@deliver');
Route::get('deliver_confirm/{username}', 'productionController@deliver_confirm');
Route::get('give/{bb}', 'productionController@give');
Route::post('give_confirm', 'productionController@give_confirm');
Route::get('receive/{username}', 'productionController@receive');
Route::get('receive_confirm/{username}', 'productionController@receive_confirm');
Route::get('bundle/{id}', 'productionController@bundle');
Route::get('bundle_confirm/{id}', 'productionController@bundle_confirm');
Route::get('to_finish', 'productionController@to_finish');
Route::get('to_complete', 'productionController@to_complete');

// Locationss table
Route::get('locations', 'locationsController@index');
Route::get('/location_new', 'locationsController@create');
Route::post('/location_insert', 'locationsController@insert');
Route::get('/location/edit/{id}', 'locationsController@edit');
Route::post('/locations/{id}', 'locationsController@update');
Route::get('/locations/delete/{id}', 'locationsController@delete');
Route::post('/locations/delete/{id}', 'locationsController@delete');
Route::get('location_import', 'locationsController@location_import');
Route::post('post_locations', 'locationsController@post_locations');

// Target
Route::get('target/{username}', 'targetController@index');
Route::post('target_confirm', 'targetController@target_confirm');
Route::post('target_enter', 'targetController@target_enter');

// Import 
Route::get('import', 'importController@index');
// Route::post('postImportUser', 'importController@postImportUser');
// Route::post('postImportRoles', 'importController@postImportRoles');
// Route::post('postImportUserRoles', 'importController@postImportUserRoles');
// Route::post('postImportUpdatePass', 'importController@postImportUpdatePass');
// Route::get('update_pitch', 'importController@update_pitch');
// Route::post('postImportSAP', 'importController@postImportSAP');
// Route::post('postImportSAPval', 'importController@postImportSAPval');
Route::post('postImport_bb_su', 'importController@postImport_bb_su');
Route::post('postImport_bb_ki', 'importController@postImport_bb_ki');

// Prepare BB
Route::get('prepare', 'bbStockPrepareController@index');
Route::get('prepare_/{function}', 'bbStockPrepareController@prepare');
Route::post('prepare_user', 'bbStockPrepareController@prepare_user');
Route::post('prepare_scan', 'bbStockPrepareController@prepare_scan');
Route::post('prepare_confirm', 'bbStockPrepareController@prepare_confirm');
Route::get('prepare_table', 'bbStockPrepareController@prepare_table');

Route::post('prepare_scan_fill', 'bbStockPrepareController@prepare_scan_fill');
Route::post('prepare_scan_fill_confirm', 'bbStockPrepareController@prepare_scan_fill_confirm');

// Extra 


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*
Route::any('getpodata', function() {
	$term = Input::get('term');

	// $data = DB::connection('sqlsrv')->table('pos')->distinct()->select('po')->where('po','LIKE', $term.'%')->where('closed_po','=','Open')->groupBy('po')->take(10)->get();
	$data = DB::connection('sqlsrv1')->select(DB::raw("SELECT TOP 10 (RIGHT([No_],6)) as po FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] WHERE [Status] = '3' AND [No_] like '%".$term."%'"));
	// var_dump($data);
	foreach ($data as $v) {
		$retun_array[] = array('value' => $v->po);
	}
return Response::json($retun_array);
});
*/