<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\bb_stock_log;

use DB;
use Log;

use Session;

class transitController extends Controller {

	public function index()
	{
		//
		return view('transit.index');
	}

	public function transitloc(Request $request)
	{
		//
		//validation
		// $this->validate($request, ['location'=>'required']);

		$input = $request->all(); 
		// dd($input);
		$location = $input['location'];
		try {
			$loc = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM locations WHERE location = '".$location."' and location_type = 'MODULE/LINE'"));
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Scaned location does not exist in production";
			return view('transit.index', compact('msg'));

		}
		
		if (!isset($loc[0]->id)) {
			$msg = "Scaned location does not exist in production";
			return view('transit.index', compact('msg'));
		}

		// Session::set('bb_to_transit', null);
		Session::set('bb_to_add_array_tr', null);
		$bbaddarray_unique_tr = null;
		return view('transit.scantotransit',compact('location','bbaddarray_unique_tr'));
	}
	
	public function set_to_transit(Request $request)
	{	
		//validation
		// $this->validate($request, ['bb_to_add'=>'required']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);
	
		$bbcode = $input['bb_to_add'];
		$location = $input['location'];
		// $inteosdb = $input['inteosdb_new'];
		$inteosdb = '1';
		// Session::set('inteosdb', $inteosdb );


		$bbaddarray_unique_tr = Session::get('bb_to_add_array_tr');
		// var_dump($bbaddarray_unique_tr);

		$msg = '';

		if ($bbcode) {

			if ($inteosdb == '1') {

				// Live database
				$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
					//continue
				} else {
		        	// $validator->errors()->add('field', 'Something is wrong with this field!');
		        	
		        	Log::error('Cannot find BB in Subotica Inteos');
		        	$msg = 'Cannot find BB in Subotica Inteos';
		        	return view('transit.scantotransit',compact('bbaddarray_unique_tr','sumofbb','msg','inteosdb', 'location'));
				}

			} elseif ($inteosdb == '2') {

				// Kikinda database
				$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
					//continue
				} else {
		        	//$validator->errors()->add('field', 'Something is wrong with this field!');
		        	
		        	Log::error('Cannot find BB in Kikinda Inteos');
		        	$msg = 'Cannot find BB in Kikinda Inteos';
		        	return view('transit.scantotransit',compact('bbaddarray_unique_tr','sumofbb','msg','inteosdb','location'));
				}
			} else {

					Log::error('Cannot find BB in any Inteos');
					$msg = 'Cannot find BB in any Inteos';
		        	return view('transit.scantotransit',compact('bbaddarray_unique_tr','sumofbb','msg','inteosdb','location'));
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
				$POnum =  $inteos_array[0]['POnum'];
				$Variant =  $inteos_array[0]['Variant'];
				$ClrDesc = $inteos_array[0]['ClrDesc'];
				$StyCod =  $inteos_array[0]['StyCod'];

				$bbaddarray = array(
				'BlueBoxCode' => $bbcode,
				'IntKeyPO' => $IntKeyPO,
				'BlueBoxNum' => $BlueBoxNum,
				'BoxQuant' => $BoxQuant,
				'BoxDateTemp' => $BoxDateTemp,
				'BoxDate' => $BoxDate,
				'POnum' => $POnum,
				'Variant' => $Variant,
				'ClrDesc' => $ClrDesc,
				'StyCod' => $StyCod
				);
			
				Session::push('bb_to_add_array_tr',$bbaddarray);
				// dd($bbaddarray);

			} else {
	        	//$validator->errors()->add('field', 'Something is wrong with this field!');
	        	
	        	// Log::error('Cannot find BB in Inteos');
	        	$msg = "Cannot find BB in Inteos";
	        	// return view('addmorebb.error', compact('msg'));
	    	}
		}

		$bbaddarray = Session::get('bb_to_add_array_tr');
		//dd($bbaddarray);

		if ($bbaddarray != null) {

			$bbaddarray_unique_tr = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));
			// dd($bbaddarray_unique_tr);
			// Session::push('bb_to_add_array',$bbaddarray_unique); // dodato sada
			
		}
		Session::set('bb_to_add_array_tr', null);
		Session::set('bb_to_add_array_tr', $bbaddarray_unique_tr);

		return view('transit.scantotransit',compact('bbaddarray_unique_tr','sumofbb','msg','inteosdb','location'));
	}

	public function remove_to_transit(Request $request)
	{
		$input = $request->all(); // change use (delete or comment user Requestl; )
		
		$bb = $input['bb'];
		$location = $input['location'];

		$bbaddarray = Session::get('bb_to_add_array_tr');
		//dd($bbaddarray);

		if ($bbaddarray != null) {

			$bbaddarray_unique_tr = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));
			// var_dump($bbaddarray_unique_tr);

			foreach ($bbaddarray_unique_tr as $line => $value) {
					
				if(in_array($bb, $value)) {
			    	unset($bbaddarray_unique_tr[$line]);
			  	}
			}
			// dd($bbaddarray_unique_tr);
			// Session::push('bb_to_add_array_tr',$bbaddarray_unique_tr); // dodato sada

			Session::set('bb_to_add_array_tr', null);
			Session::set('bb_to_add_array_tr', $bbaddarray_unique_tr);


		}

		return view('transit.scantotransit',compact('bbaddarray_unique_tr','location'));
	}

	public function addbb_to_transit(Request $request)
	{	

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);

		$location = $input['location'];
		// dd($location);

		if (isset($input['bbaddarray_unique_tr'])) {
			
			$bbaddarray = $input['bbaddarray_unique_tr'];

		} else {

			$bbaddarray = Session::get('bb_to_add_array_tr');
			// dd($bbaddarray);
		}
		
		//dd($bbaddarray_unique);
		if ( isset($bbaddarray) AND !empty($bbaddarray) ) {

			// dd($bbaddarray);
			$bbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));

			foreach ($bbaddarray_unique as $line) {

				// dd($line["BlueBoxNum"]);
				// dd($line);

				$bbcode = $line['BlueBoxCode'];
				$bbname = $line['BlueBoxNum'];
				//$po = $line['POnum'];
				$po = substr($line['POnum'], -6);
				$style = $line['StyCod'];
				$qty = $line['BoxQuant'];
				$boxdate = $line['BoxDate'];

				$numofbb = 0;

				$location = $location; 

				$status = "TRANSIT";

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
					$bbStock->style = $style;
					$bbStock->color = $color;
					$bbStock->size = $size;
					$bbStock->qty = $qty;
					$bbStock->boxdate = $boxdate;
					$bbStock->numofbb = $numofbb;
					$bbStock->location = $location;
					$bbStock->status = $status;

					$bbStock->save();
				}
				catch (\Illuminate\Database\QueryException $e) {
					
					//return view('bbstock.error');		
					
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
					// $bbstockold->style = $style;
					// $bbstockold->color = $color;
					// $bbstockold->size = $size;
					// $bbstockold->qty = $qty;
					// $bbstockold->boxdate = $boxdate;
					// $bbstockold->numofbb = $numofbb;
					$bbstockold->location = $location;
					$bbstockold->status = $status;
					
					$bbstockold->save();
				}

				// return view('bbstock.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			}

			Session::set('bb_to_add_array_tr', null);
			$msg = "All scanned BB succesfuly add to TRANSIT";
			return view('transit.success',compact('msg'));
		}

		Session::set('bb_to_add_array_tr', null);
		$msg = "List of BB to add is empty";
		return view('transit.error',compact('msg'));
		
	}
}
