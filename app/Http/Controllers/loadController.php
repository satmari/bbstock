<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\locations;
use App\bb_stock_log;

use DB;
use Log;

use Session;

class loadController extends Controller {

	public function index()
	{
		//
		$locations = locations::orderBy('id')->where('location_type','=','RECEIVING')->lists('location','location');
		return view('loadbb.index', compact("locations"));
	}

	public function loadloc(Request $request)
	{
		//
		//validation
		// $this->validate($request, ['location'=>'required']);

		$input = $request->all(); 
		// dd($input);
		$location = $input['location_new'];
		// dd($location);

		// For error
		$locations = locations::orderBy('id')->where('location_type','=','RECEIVING')->lists('location','location');

		if ($input['location_new'] == '') {
			$msg = "Scaned location doesn't have RECEIVING type";
			return view('loadbb.index', compact('locations','msg'));
		}

		try {
			$loc = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM locations WHERE location = '".$location."' and location_type = 'RECEIVING'"));
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Scaned location doesn't have RECEIVING type";
			return view('loadbb.index', compact('locations','msg'));

		}
		
		if (!isset($loc[0]->id)) {
			$msg = "Scaned location doesn't have RECEIVING type";
			return view('loadbb.index', compact('locations','msg'));
		}

		// Session::set('bb_to_transit', null);
		Session::set('bb_to_load_array_tr', null);
		$bbloadarray_unique_tr = null;
		return view('loadbb.scantoload',compact('location','bbloadarray_unique_tr'));
	}
	
	public function set_to_load(Request $request)
	{	
		//validation
		// $this->validate($request, ['bb_to_load'=>'required']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);
		
		$bbcode = $input['bb_to_load'];
		$location = $input['location'];
		// $inteosdb = $input['inteosdb_new'];
		$inteosdb = '1';
		// Session::set('inteosdb', $inteosdb );

		$bbloadarray_unique_tr = Session::get('bb_to_load_array_tr');
		// var_dump($bbaddarray_unique_tr);

		$msg = '';

		if ($bbcode) {

			if ($inteosdb == '1') {

				// Live database
				$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
					//continue
				} else {
		        	// $validator->errors()->add('field', 'Something is wrong with this field!');
		        	
		        	Log::error('Cannot find BB in Gordon Inteos');
		        	$msg = 'Cannot find BB in Gordon Inteos';
		        	return view('loadbb.scantoload',compact('bbloadarray_unique_tr','sumofbb','msg','inteosdb', 'location'));
				}

			} elseif ($inteosdb == '2') {

				// Kikinda database
				$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
					//continue
				} else {
		        	//$validator->errors()->add('field', 'Something is wrong with this field!');
		        	
		        	Log::error('Cannot find BB in Kikinda Inteos');
		        	$msg = 'Cannot find BB in Kikinda Inteos';
		        	return view('loadbb.scantoload',compact('bbloadarray_unique_tr','sumofbb','msg','inteosdb','location'));
				}
			} else {

					Log::error('Cannot find BB in any Inteos');
					$msg = 'Cannot find BB in any Inteos';
		        	return view('loadbb.scantoload',compact('bbloadarray_unique_tr','sumofbb','msg','inteosdb','location'));
			}
		
			if ($inteos) {
			//continue

				function object_to_array($data)
				{
				    if (is_array($data) || is_object($data))
				    {
				        $result = array();
				        foreach ($data as $key => $value)
				        {
				            $result[$key] = object_to_array($value);
				        }
				        return $result;
				    }
				    return $data;
				}

				$inteos_array = object_to_array($inteos);

				$BlueBoxCode = $bbcode;
				//$InitKey = $inteos_array[0]['INTKEY'];
				$IntKeyPO =  $inteos_array[0]['IntKeyPO'];
				$BlueBoxNum =  $inteos_array[0]['BlueBoxNum'];
				$BoxQuant =  $inteos_array[0]['BoxQuant'];
				
				$BoxDateTemp =  $inteos_array[0]['CREATEDATE'];
				$timestamp = strtotime($BoxDateTemp);
				$BoxDate = date('Y-m-d H:i:s', $timestamp);
				//dd($BoxDate);
				// $POnum =  $inteosinput[0]['POnum'];
				$POnum = substr($inteos_array[0]['POnum'], -6); 
				$SMVloc = $inteos_array[0]['SMVloc'];

				$Variant =  $inteos_array[0]['Variant'];
				$ClrDesc = $inteos_array[0]['ClrDesc'];
				$StyCod =  $inteos_array[0]['StyCod'];

				$bbloadarray = array(
				'BlueBoxCode' => $bbcode,
				'IntKeyPO' => $IntKeyPO,
				'BlueBoxNum' => $BlueBoxNum,
				'BoxQuant' => $BoxQuant,
				'BoxDateTemp' => $BoxDateTemp,
				'BoxDate' => $BoxDate,
				'POnum' => $POnum,
				'SMVloc' => $SMVloc,
				'Variant' => $Variant,
				'ClrDesc' => $ClrDesc,
				'StyCod' => $StyCod
				);
			
				Session::push('bb_to_load_array_tr',$bbloadarray);
				// dd($bbloadarray);

			} else {
	        	//$validator->errors()->add('field', 'Something is wrong with this field!');
	        	
	        	// Log::error('Cannot find BB in Inteos');
	        	$msg = "Cannot find BB in Inteos";
	        	// return view('addmorebb.error', compact('msg'));
	    	}
		}

		$bbloadarray = Session::get('bb_to_load_array_tr');
		// var_dump($bbloadarray);

		if ($bbloadarray != null) {

			$bbloadarray_unique_tr = array_map("unserialize", array_unique(array_map("serialize", $bbloadarray)));
			// dd($bbloadarray_unique_tr);
			// Session::push('bb_to_load_array',$bbloadarray_unique); // dodato sada
			
		}
		// Session::set('bb_to_load_array_tr', null);
		// Session::set('bb_to_load_array_tr', $bbloadarray_unique_tr);
		// var_dump($bbloadarray_unique_tr);

		return view('loadbb.scantoload',compact('bbloadarray_unique_tr','msg','location'));
	}

	public function remove_to_load(Request $request)
	{
		$input = $request->all(); // change use (delete or comment user Requestl; )
		
		$bb = $input['bb'];
		$location = $input['location'];

		$bbloadarray = Session::get('bb_to_load_array_tr');
		//dd($bbloadarray);

		if ($bbloadarray != null) {

			$bbloadarray_unique_tr = array_map("unserialize", array_unique(array_map("serialize", $bbloadarray)));
			// var_dump($bbloadarray_unique_tr);

			foreach ($bbloadarray_unique_tr as $line => $value) {
					
				if(in_array($bb, $value)) {
			    	unset($bbloadarray_unique_tr[$line]);
			  	}
			}
			// dd($bbloadarray_unique_tr);
			// Session::push('bb_to_load_array_tr',$bbloadarray_unique_tr); // dodato sada

			Session::set('bb_to_load_array_tr', null);
			Session::set('bb_to_load_array_tr', $bbloadarray_unique_tr);

		}

		return view('loadbb.scantoload',compact('bbloadarray_unique_tr','location'));
	}

	public function addbb_to_load(Request $request)
	{	

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);

		$location = $input['location'];
		// dd($location);

		if (isset($input['bbloadarray_unique_tr'])) {
			
			$bbloadarray = $input['bbloadarray_unique_tr'];

		} else {

			$bbloadarray_get = Session::get('bb_to_load_array_tr');

			if (isset($bbloadarray_get)){
				$bbloadarray_unique_tr = array_map("unserialize", array_unique(array_map("serialize", $bbloadarray_get)));
				$bbloadarray = $bbloadarray_unique_tr;

			} else {
				Session::set('bb_to_load_array_tr', null);
				$msg = "List of BB to add is empty, try again!";
				return view('loadbb.error',compact('msg'));
			}
			
		}
		
		//dd($bbloadarray_unique);
		if (isset($bbloadarray) AND !empty($bbloadarray) ) {

			// dd($bbloadarray);
			// $bbloadarray_unique = array_map("unserialize", array_unique(array_map("serialize", $bbloadarray)));

			foreach ($bbloadarray as $line) {

				// dd($line["BlueBoxNum"]);
				// dd($line);

				$bbcode = $line['BlueBoxCode'];
				$bbname = $line['BlueBoxNum'];
				//$po = $line['POnum'];
				$po = $line['POnum'];
				$smv = $line['SMVloc'];
				$style = $line['StyCod'];
				$qty = $line['BoxQuant'];
				$boxdate = $line['BoxDate'];

				$numofbb = 0;

				$location = strtoupper($location); 

				$status = "TRAVELING";

				$brlinija = substr_count($line['Variant'],"-");
				// echo $brlinija." ";

				if ($brlinija == 2)
				{
					list($ColorCode, $size1, $size2) = explode('-', $line['Variant']);
					$Size = $size1."-".$size2;
					// echo $color." ".$size;	
				} else {
					list($ColorCode, $Size) = explode('-', $line['Variant']);
					// echo $color." ".$size;
				}

				$color = $ColorCode;
				$size = $Size;

				try {
					$bbStock = new bbStock;
					$bbStock->bbcode = $bbcode;
					$bbStock->bbname = $bbname;
					$bbStock->po = $po;
					$bbStock->pitch_time = round($smv / 20 * $qty, 3);
					$bbStock->style = $style;
					$bbStock->color = $color;
					$bbStock->size = $size;
					$bbStock->qty = $qty;
					$bbStock->boxdate = $boxdate;
					$bbStock->numofbb = $numofbb;
					$bbStock->location = strtoupper($location);
					$bbStock->status = $status;

					$bbStock->save();
				}
				catch (\Illuminate\Database\QueryException $e) {
					
					//return view('loadbb.error');
					
					$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM bbStock WHERE bbname = '".$bbname."'"));
					//dd($bb);
					foreach ($bb as $b) {
						$bbid = $b->id;
					}

					$bbstockold = bbStock::findOrFail($bbid);
					// dd($bb);
					// $bbstockold->delete();
					// $bbstockold = new bbStock;

					// $bbstockold->bbcode = $bbcode;
					// $bbstockold->bbname = $bbname;
					// $bbstockold->po = $po;
					// $bbstockold->pitch_time = round($smv / 20 * $qty, 3);
					// $bbstockold->style = $style;
					// $bbstockold->color = $color;
					// $bbstockold->size = $size;
					// $bbstockold->qty = $qty;
					// $bbstockold->boxdate = $boxdate;
					// $bbstockold->numofbb = $numofbb;
					$bbstockold->location = strtoupper($location);
					$bbstockold->status = $status;
					
					$bbstockold->save();
				}

				
			}

			Session::set('bb_to_load_array_tr', null);
			$msg = "All scanned BB succesfuly changed status to TRAVELING";
			return view('loadbb.success',compact('msg'));
		}

		Session::set('bb_to_load_array_tr', null);
		$msg = "List of BB to add is empty";
		return view('loadbb.error',compact('msg'));
		
	}

	public function index_unload()
	{
		//
		$locations = locations::orderBy('id')->where('location_type','=','RECEIVING')->lists('location','location');
		return view('loadbb.index_unload', compact("locations"));
	}

	public function unloadloc(Request $request)
	{
		//
		$input = $request->all(); // change use (delete or comment user Requestl; )
		$location = strtoupper($input['location_new']);

		// For error
		$locations = locations::orderBy('id')->where('location_type','=','RECEIVING')->lists('location','location');

		if ($input['location_new'] == '') {
			$msg = "Scaned location doesn't have RECEIVING type";
			return view('loadbb.index_unload', compact('locations','msg'));
		}

		try {
			$loc = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM locations WHERE location = '".$location."' and location_type = 'RECEIVING'"));
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Scaned location doesn't have RECEIVING type";
			return view('loadbb.index_unload', compact('locations','msg'));

		}
		
		if (!isset($loc[0]->id)) {
			$msg = "Scaned location doesn't have RECEIVING type";
			return view('loadbb.index_unload', compact('locations','msg'));
		}


		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT COUNT(id) as c FROM bbStock WHERE location = '".$location."' and status = 'TRAVELING'"));

		if (isset($bbs[0]->c)) {
			$c = $bbs[0]->c;
		} else {
			$c = 0;
		}
		return view('loadbb.unload_conf', compact('c','location'));
	}

	public function unloadloc_confirm(Request $request)
	{

		$input = $request->all(); // change use (delete or comment user Requestl; )
		$location = strtoupper($input['location']);


		try {

		$da = date("Y-m-d H:i:s");
		// dd($da);

		$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
			SET status = 'STOCK', updated_at = '".$da."'
			OUTPUT INSERTED.id
			WHERE location = '".$location."' and status = 'TRAVELING' "));
		}
		catch (\Illuminate\Database\QueryException $e) {

			$da = date("Y-m-d H:i:s");
			// dd($da);

			$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
			SET status = 'STOCK', updated_at = '".$da."'
			OUTPUT INSERTED.id
			WHERE location = '".$location."' and status = 'TRAVELING' "));
		
		}

		return redirect('/');


	}
}
