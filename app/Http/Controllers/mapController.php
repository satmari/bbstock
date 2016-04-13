<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use DB;

class mapController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view('map.index');
	}

	public function showbygroup($id)
	{
		//
		if ($id == "group1") {
			$searchid =  "GROUP 1";
		} elseif  ($id == "group2") { 
			$searchid =  "GROUP 2";
		} else {
			$searchid = $id."-%";
		}

		$bbstockbygroup = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE location LIKE '".$searchid."'"));
		// dd($bbstockbygroup);

		if ($id == "group1") { 
			$id = "GROUP 1";
			return view('map.mapbygrouptemp',compact('id','bbstockbygroup'));
		} elseif  ($id == "group2") { 
			$id = "GROUP 2";
			return view('map.mapbygrouptemp',compact('id','bbstockbygroup'));
		} else {
			return view('map.mapbygroup',compact('id','bbstockbygroup'));
		}
	}
	

}
