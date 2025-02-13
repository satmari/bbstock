<?php namespace App\Http\Controllers;

// use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request; // for save
// use Request; // For import
use Illuminate\Support\Facades\Redirect;

use Maatwebsite\Excel\Facades\Excel;

use App\locations;
use DB;


class locationsController extends Controller {


	public function index()
	{
		//
		$locations = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM locations "));
		return view('locations.index', compact('locations'));
	}

	public function create()
	{
		//
		return view('locations.create');
	}

	public function insert(Request $request)
	{
		//
		$this->validate($request, ['location'=>'required']);

		$location_input = $request->all(); // change use (delete or comment user Requestl; )
		
		// dd($location_input['location']);
		$location = $location_input['location'];
		$location_type = $location_input['location_type'];
		$location_dest = $location_input['location_dest'];
		
		$table_count = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM locations "));

		// dd(count($table_count)+1);
		$id = count($table_count) + 1;

		// try {
			$table = new locations;


			$table->id = $id;
			$table->location = $location;
			$table->location_type = $location_type;
			$table->location_dest = $location_dest;
						
			$table->save();
		// }
		// catch (\Illuminate\Database\QueryException $e) {
		// 	return view('locations.error');			
		// }
		
		return Redirect::to('/locations');

	}

	public function edit($id) {

		$location = locations::findOrFail($id);		
		return view('locations.edit', compact('location'));
	}

	public function update($id, Request $request) {
		//
		$this->validate($request, ['location'=>'required']);

		$table = locations::findOrFail($id);		
		$input = $request->all(); 
		
		// try {
			$table->location = $input['location'];
			$table->location_type = $input['location_type'];
			$table->location_dest = $input['location_dest'];
					
			$table->save();
		// }
		// catch (\Illuminate\Database\QueryException $e) {
		// 	return view('locations.error');			
		// }
		
		return Redirect::to('/locations');
	}

	public function delete($id) {

		$location = locations::findOrFail($id);
		$location->delete();

		return Redirect::to('/locations');
	}

	public function location_import() 
	{
		return view('locations.locations_import');				
	}

	public function post_locations(Request $request) {
	    $getSheetName = Excel::load(Request::file('file'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            // DB::table('users')->truncate();
				// DB::statement('SET FOREIGN_KEY_CHECKS=1;');

	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file'))->chunk(500, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {

	                	// ADD
	                	/*
						$location1 = new locations;
						$location1->location = $row['location'];
						$location1->location_type = $row['location_type'];
						$location1->location_dest = $row['location_dest'];
						$location1->save();
						*/

						// UPDATE
						$locations = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM locations WHERE location = '". $row['location']."' "));
						// dd($locations);

						$location1 = locations::findOrFail($locations[0]->id);	
						// $location1->location = $input['location'];
						// $location1->location_type = $input['location_type'];
						$location1->location_dest = $row['location_dest'];
						$location1->save();
						

					}
	            });
	    }
		return redirect('/');
	}

}
