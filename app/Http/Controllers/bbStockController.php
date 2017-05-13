<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\bbStock;

use DB;

class bbStockController extends Controller {

	public function index(/*Request $request*/)	{


	    //return view('bbstock.create');
	}
	public function create(Request $request) {
		//
		//validation
		$this->validate($request, ['BlueBoxCode'=>'required','QtyofBB'=>'required','BBLocation' => 'required']);

		$inteosinput = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		$bbcode = $inteosinput['BlueBoxCode'];
		$bbname = $inteosinput['BlueBoxNum'];
		//$po = $inteosinput['POnum'];
		$po = substr($inteosinput['POnum'], -5); 
		$style = $inteosinput['StyCod'];
		$color = $inteosinput['ColorCode'];
		$size = $inteosinput['Size'];
		$qty = $inteosinput['BoxQuant'];
		$boxdate = $inteosinput['BoxDate'];
		$numofbb = $inteosinput['QtyofBB'];
		$location = $inteosinput['BBLocation'];
	

		//$variant = $inteosinput['Variant'];
		//$colordes = $inteosinput['ClrDesc'];

		try {
			$bbStock = new bbStock;

			$bbStock->bbcode = $bbcode;
			$bbStock->bbname = $bbname;
			$bbStock->po = $po;
			$bbStock->style = $style;
			$bbStock->color = $color;
			$bbStock->size = $size;
			$bbStock->qty = $qty;
			$bbStock->boxdate = $boxdate;
			$bbStock->numofbb = $numofbb;
			$bbStock->location = $location;

			$bbStock->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			
			
			//return view('bbstock.error');		

			

			
			$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE bbname = '".$bbname."'"));
			//dd($bb);
			foreach ($bb as $b) {
				$bbid = $b->id;
			}

			$bbstockold = bbStock::findOrFail($bbid);
			// dd($bb);
			$bbstockold->delete();


			$bbStock = new bbStock;
			$bbStock->bbcode = $bbcode;
			$bbStock->bbname = $bbname;
			$bbStock->po = $po;
			$bbStock->style = $style;
			$bbStock->color = $color;
			$bbStock->size = $size;
			$bbStock->qty = $qty;
			$bbStock->boxdate = $boxdate;
			$bbStock->numofbb = $numofbb;
			$bbStock->location = $location;
			$bbStock->save();
			
		}
		
		return view('bbstock.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
	}
	public function show($id) {

		$bb = bbStock::findOrFail($id);
		return view('bbstock.show', compact('bb'));
	}
	public function edit($id) {

		$bb = bbStock::findOrFail($id);		
		return view('bbstock.edit', compact('bb'));
	}
	public function update($id, Request $request) {

		$bb = bbStock::findOrFail($id);		

		$bb->update($request->all());


		return view('bbstock.show', compact('bb'));
	}
	public function delete($id) {

		$bb = bbStock::findOrFail($id);
		// dd($bb);
		$bb->delete();

		return Redirect::to('/table');
	}
}
