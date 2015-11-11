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

//Route::resource('bbstock', 'bbstockController');

Route::get('removebb', 'removebbController@index');
Route::get('removebb/destroy', 'removebbController@destroy');
Route::post('removebb/destroy', 'removebbController@destroy');

Route::get('search', 'searchController@index');
Route::post('search', 'searchController@search');

Route::get('export', 'exportController@create');

//Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// ---------------------------------------------------------------------------------

/**
 * Laravel / jQuery AJAX code example
 * See conversation here: http://laravel.io/forum/04-29-2015-people-asking-about-jquery-ajax
 *
 * Drop this code into your App/Http/routes.php file, and go to /ajax/view in your browser
 * Be sure to bring up the JavaScript console by pressing F12.
 */


// This is your View AJAX route - load this in your browser
Route::get('/ajax/view', function () {

	// really all this should be set up as a view, but I'm showing it here as
	// inline html just to be easy to drop into your routes file and test
	?>

		<!-- jquery library -->
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

		<!-- pass through the CSRF (cross-site request forgery) token -->
		<meta name="csrf-token" content="<?php echo csrf_token() ?>" />

		<!-- some test buttons -->
		<button id="get">Get data</button>
		<button id="post">Post data</button>
		<br>
		<input type="test" class="form-control" name="email" value="" id="inputdata">
		<!-- your custom code -->
		<script>

			// set up jQuery with the CSRF token, or else post routes will fail
			$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

			// handlers
			function onGetClick(event)
			{
				// we're not passing any data with the get route, though you can if you want
				$.get('/ajax/get', onSuccess);
			}

			function onPostClick(event)
			{
				// we're passing data with the post route, as this is more normal
				var inputdata = $("#inputdata").val();

				//console.log("inputdata : " + inputdata);
				$.post('/ajax/post', {input: inputdata}, onSuccess);
			}

			function onSuccess(data, status, xhr)
			{
				// with our success handler, we're just logging the data...
				//console.log(data, status, xhr);
				//console.log(data);
				//console.log();
				//console.log('xhr: ' + xhr);
				var inputdata = data['input'];
				console.log('inputdata: ' + inputdata);

				// but you can do something with it if you like - the JSON is deserialised into an object
				//console.log(String(data.value));


			}

			// listeners
			$('button#get').on('click', onGetClick);
			$('button#post').on('click', onPostClick);

		</script>

	<?php
});

// this is your GET AJAX route
Route::get('/ajax/get', function () {

	// pass back some data
	$data   = array('value' => 'some data');

	// return a JSON response
	return  Response::json($data);
});

// this is your POST AJAX route
Route::post('/ajax/post', function () {

	// pass back some data, along with the original data, just to prove it was received
	//$data   = array('value' => 'some data', 'input' => Request::input());
	//$input = Request::input();
	
	//$data  = array('value' => 'some data', 'input' => Request::input());
	$data  = Request::input();

	// return a JSON response
	return  Response::json($data);
});