<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\bbStock;

use DB;

class palletController extends Controller {

	public function select_pallet()
	{
		//
		return view('pallet.select_pallet');
	}

	public function select_pallet_confirm(Request $request) {

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);
		$pallet = strtoupper($input['pallet']);
		// dd($pallet);

		$pallet_in_db = DB::connection('sqlsrv')->select(DB::raw("SELECT
		 * FROM bbstock WHERE pallet = '".$pallet."' and (location = 'RECEIVING KI WH' or location = 'SENTA WH') and status = 'STOCK' "));
		// $pallet_in_db = DB::connection('sqlsrv')->select(DB::raw("SELECT count(id) FROM [bbStock].[dbo].bbstock WHERE pallet = '".$pallet."' and location = 'RECEIVING KI WH' and status = 'STOCK' "));
		// dd($pallet_in_db);

		if (!isset($pallet_in_db[0]->id)) {
			$msg = 'Pallet not exist in RECEIVING KI WH or SENTA WH with status STOCK';
			return view('pallet.error', compact('msg'));
		}

		return view('pallet.select_location', compact('pallet'));
	}

	public function select_location_confirm(Request $request) {

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// dd($input);

		$pallet = strtoupper($input['pallet']);
		$location = strtoupper($input['location']);
		// dd(substr($location, 0,8));
		// var_dump("Pallet is: ".$pallet." ,");
		// var_dump("Location is: ".$location." ,");

		// dd(substr($location, 0,6));

		if (((substr($location, 0,8) != 'KIK TEMP') and (substr($location, 0,6)) != 'SENTA-') and ($location != 'NO_BALZA')) {
			$msg = 'Location must start with KIK TEMP , SENTA- or NO_BALZA';
			return view('pallet.error', compact('msg'));
		}

		$bb_to_set  = DB::connection('sqlsrv')->select(DB::raw("SELECT
		 * FROM bbstock WHERE pallet = '".$pallet."' and (location = 'RECEIVING KI WH' or location = 'SENTA WH') and status = 'STOCK' "));
		// dd($bb_to_set);

		$count_list = count($bb_to_set);
		// dd($count_list);
		// var_dump("Number of lines: ".count($bb_to_set)." . <br> ");

		if (isset($bb_to_set[0]->id)) {
			
			for ($i=0; $i < count($bb_to_set); $i++) { 
				
				$bbstock = bbStock::findOrFail($bb_to_set[$i]->id);
				$bbstock->location = $location;
				$bbstock->pallet = '';
				$bbstock->save();
				// var_dump("BB= ".$bbstock->bbname." , done. <br>");
			}
		}

		$msg = "All ".strval($count_list)." boxes are moved to ".$location;
		return view('pallet.success', compact('msg'));


	}


}
