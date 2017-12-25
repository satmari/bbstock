<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use DB;

class searchController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view('search.index');
	}

	public function index2()
	{
		//
		return view('search.index2');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search(Request $request)
	{
		//
		//remove BB
		//validation
		//$this->validate($request, ['bb_code'=>'required|max:10']);
		$this->validate($request, ['po'=>'min:6|max:6']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		//$bb_code = $input['bb_code'];
		$po = $input['po'];
		$size = $input['size'];

		// Search -----------------------------------------------------
		// serach by bb_code
		//$search = bbStock::where('bbcode', '=', $bb_code)->first();

		$q = bbStock::query();

		if ($po) {
			$q->searchpo($po);
		}

		if ($size) {
			$q->searchsize($size);
		}

		$search = $q->get()->sortByDesc('location');
		
		// if ($po) {
		// 	$search1 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE po = ".$po." ORDER BY boxdate"));
		// } else if ($size) {
		// 	$search1 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE size = ".$size));
		// } else {
		// 	$search1 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock "));
		// }

		if ($search == false) {
		 	return view('search.error'); //1971107960
		} else {
			//return view('search.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			return view('search.success', compact('search'));
		}

	}

	public function search2(Request $request)
	{
		//
		//remove BB
		//validation
		//$this->validate($request, ['bb_code'=>'required|max:10']);
		$this->validate($request, ['po'=>'min:6|max:6']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		//$bb_code = $input['bb_code'];
		$po = $input['po'];
		$size = $input['size'];


		$q = bbStock::query();

		if ($po) {
			$q->searchpo($po);
		}

		if ($size) {
			$q->searchsize($size);
		}

		$search = $q->get()->sortByDesc('location');
		$search_by_date = $q->get()->sortBy('boxdate');

		// Search -----------------------------------------------------
		/*
		if (($input['po']) AND ($input['size'])) {
			$po = $input['po'];
			$size = $input['size'];
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE po = ".$po." AND size = ".$size." ORDER BY boxdate"));

		} else if ($input['po']) {
			$po = $input['po'];
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE po = ".$po." ORDER BY boxdate"));

		} else if ($input['size']) {
			$size = $input['size'];
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE size = ".$size." ORDER BY boxdate"));

		} else {
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock ORDER BY boxdate"));
		}
		*/

		if ($search == false) {
		 	return view('search.error'); //1971107960
		} else {
			//return view('search.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			return view('search.success2', compact('search','search_by_date'));
		}


	}

	

}
