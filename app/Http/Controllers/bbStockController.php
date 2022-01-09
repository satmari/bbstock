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
		// $this->validate($request, ['BlueBoxCode'=>'required','QtyofBB'=>'required','BBLocation' => 'required']);

		$inteosinput = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		$BlueBoxCode = $inteosinput['BlueBoxCode'];
		$BlueBoxNum = $inteosinput['BlueBoxNum'];
		//$po = $inteosinput['POnum'];
		$POnum = $inteosinput['POnum'];
		// $po = substr($inteosinput['POnum'], -6); 

		$brcrtica = substr_count($inteosinput['POnum'],"-");
		// echo $brcrtica." ";
		if ($brcrtica == 1)
		{
			list($one, $two) = explode('-', $inteosinput['POnum']);
			$po = $one;
		} else {
			$po = substr($inteosinput['POnum'],-6);
		}

		$SMVloc = $inteosinput['SMVloc'];
		$StyCod = $inteosinput['StyCod'];
		$ColorCode = $inteosinput['ColorCode'];
		$Size = $inteosinput['Size'];
		$BoxQuant = $inteosinput['BoxQuant'];
		$BoxDate = $inteosinput['BoxDate'];
		$QtyofBB = $inteosinput['QtyofBB'];
		$location = $inteosinput['BBLocation'];
		$status = "STOCK";

		$Variant = $inteosinput['Variant'];
		$ClrDesc = $inteosinput['ClrDesc'];

		$Bagno = $inteosinput['Bagno'];

		$loc = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM locations WHERE location = '".$location."' and (location_type = 'STOCK' or location_type = 'RECEIVING')"));
		
		if (!isset($loc[0]->id)) {
			$msg = "Scaned location does not exist, or is not correct type of location. ";
			return view('inteosdb.create', compact('BlueBoxCode', 'BlueBoxNum', 'BoxQuant', 'BoxDate','POnum','SMVloc', 'Variant', 'ClrDesc', 'StyCod', 'Bagno', 'ColorCode', 'Size', 'QtyofBB', 'msg' ));
		}

		$style_sap = str_pad($StyCod, 9); 
		$color_sap = str_pad($ColorCode, 4);
		$size_sap = str_pad($Size, 5);

		$sku = $style_sap.$color_sap.$size_sap;
		
		try {
			$bbStock = new bbStock;

			$bbStock->bbcode = $BlueBoxCode;
			$bbStock->bbname = $BlueBoxNum;
			$bbStock->po = $po;
			$bbStock->pitch_time = round($SMVloc / 20 * $BoxQuant, 3);
			$bbStock->style = $StyCod;
			$bbStock->color = $ColorCode;
			$bbStock->size = $Size;
			$bbStock->qty = $BoxQuant;
			$bbStock->boxdate = $BoxDate;
			$bbStock->numofbb = $QtyofBB;

			$bbStock->location = strtoupper($location);
			$bbStock->status = $status;

			$bbStock->bagno = $Bagno;

			$bbStock->sku = $sku;

			$bbStock->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			
			
			//return view('bbstock.error');		
			
			$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE bbname = '".$BlueBoxNum."'"));
			//dd($bb);
			foreach ($bb as $b) {
				$bbid = $b->id;
			}
			
			$bbstockold = bbStock::findOrFail($bbid);
			// dd($bb);
			// $bbstockold->delete();
			
			// $bbstockold = new bbStock;
			$bbstockold->bbcode = $BlueBoxCode;
			$bbstockold->bbname = $BlueBoxNum;
			$bbstockold->po = $po;
			$bbstockold->pitch_time = round($SMVloc / 20 * $BoxQuant, 3);
			$bbstockold->style = $StyCod;
			$bbstockold->color = $ColorCode;
			$bbstockold->size = $Size;
			$bbstockold->qty = $BoxQuant;
			$bbstockold->boxdate = $BoxDate;
			$bbstockold->numofbb = $QtyofBB;

			$bbstockold->location = strtoupper($location);
			$bbstockold->status = $status;
			$bbstockold->bagno = $Bagno;
			$bbstockold->sku = $sku;

			$bbstockold->save();
			
		}
		
		return view('bbstock.success', compact('BlueBoxNum','po','StyCod','ColorCode','Size','BoxQuant','QtyofBB','location'));
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

	public function delete_pallet($id) {

		$bb = bbStock::findOrFail($id);
		$bb->pallet = '';
		$bb->save();

		return Redirect::to('/table');
	}
}
