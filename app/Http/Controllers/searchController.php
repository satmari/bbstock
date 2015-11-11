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
		$this->validate($request, ['po'=>'min:5|max:5']);

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

		$search = $q->get();

		//$search = bbStock::SearchPo()->get();

		//var_dump($search);
		/*
		$bbcode = $search['bbcode'];
		$bbname = $search['bbname'];
		$po = $search['po'];
		$style = $search['style'];
		$color = $search['color'];
		$size = $search['size'];
		$qty = $search['qty'];
		$numofbb = $search['numofbb'];
		$location = $search['location'];
		*/

		if ($search == false) {
		 	return view('search.error'); //1971107960
		} else {
			//return view('search.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			return view('search.success', compact('search'));
		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
