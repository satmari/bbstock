<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\bb_stock_log;
use DB;

class mapController extends Controller {

	public function index()	{
		//
		return view('map.index');
	}

	public function showbygroup($id) {
		//
		if ($id == "group1") {
			$searchid =  "GROUP 1";
		} elseif  ($id == "group2") { 
			$searchid =  "GROUP 2";
		} elseif  ($id == "suspended") { 
			$searchid =  "SUSPENDED";
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
		} elseif  ($id == "suspended") { 
			$id = "SUSPENDED";
			return view('map.mapbygrouptemp',compact('id','bbstockbygroup'));
		} else {
			return view('map.mapbygroup',compact('id','bbstockbygroup'));
		}
	}

	public function table() {

		$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT b.*
			,(SELECT location_dest FROM [bbStock].[dbo].[locations] WHERE b.location = location) as destination
			,(SELECT 
					CASE 
						WHEN COUNT(status) > 0 THEN 'NOT READY'
						ELSE 'READY'
					END
				FROM [bbStock].[dbo].[bbStock_extras]
				WHERE bbcode = b.[bbcode] and status = 'NOT DONE'
				) as bb_ready
			FROM bbStock as b
			ORDER BY b.location asc, b.status asc, b.updated_at asc"));
		return view('map.showtable',compact('bbstock'));
	}
	
	public function tablelog() {

		$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bb_stock_logs WHERE DATEDIFF(day, created_at, GETDATE()) <= 30 ORDER BY updated_at desc"));
		return view('map.showtablelog',compact('bbstock'));
	}

	public function bundlelog() {

		$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bundlelogs WHERE DATEDIFF(day, created_at, GETDATE()) <= 30 ORDER BY updated_at desc"));
		return view('map.bundlelog',compact('bbstock'));
	}

	public function deliveredlog() {

		$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM deliveredlogs WHERE DATEDIFF(day, created_at, GETDATE()) <= 30 ORDER BY updated_at desc"));
		return view('map.deliveredlog',compact('bbstock'));
	}
	

}
