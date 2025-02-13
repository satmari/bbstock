<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\bbStock;

use DB;
use Log;

use Session;

class inteosdbController extends Controller {

	public function index()	{

        //return view('bbstock.index', compact('bbstock'));
        
        $inteosdb = Session::get('inteosdb');
        // dd($inteosdb);

        if (is_null($inteosdb)) {
        	$inteosdb = '1';
        }

        // if ($inteosdb == '3') {
        // 	$inteosdb = '1';
        // }
        
        return view('inteosdb.index',compact('inteosdb'));
	}

	public function create(Request $request) {
		//
		$this->validate($request, ['inteos_bb_code' => 'required|max:10']);

		$inteosinput = $request->all(); // change use (delete or comment user Requestl; )
		//1971107960
		// 916333089 // double BB INTKEY

		$inteosbbcode = $inteosinput['inteos_bb_code'];
		$inteosdb = $inteosinput['inteosdb_new'];
		Session::set('inteosdb', $inteosdb );


		if (($inteosdb == '1') OR ($inteosdb == '3')) {

			// Live database
			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY
				,[CNF_BlueBox].IntKeyPO
				,[CNF_BlueBox].BlueBoxNum
				,[CNF_BlueBox].BoxQuant
				,[CNF_BlueBox].CREATEDATE
				,[CNF_PO].POnum
				,[CNF_PO].SMVloc
				,[CNF_SKU].Variant
				,[CNF_SKU].ClrDesc
				,[CNF_STYLE].StyCod
				,[CNF_BlueBox].Bagno
				 FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO 
				 FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY 
				 FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY 
				 WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
				'somevariable' => $inteosbbcode,
			));
			
			if ($inteos) {
				//continue
			} else {
	        	// $validator->errors()->add('field', 'Something is wrong with this field!');
	        	
	        	Log::error('Cannot find BB in Subotica or Senta Inteos');
	        	$msg = 'Cannot find BB in Subotica or Senta Inteos';
	        	return view('inteosdb.error', compact('msg'));
			}

		} elseif ($inteosdb == '2') {

			// Kikinda database
			$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY
				,[CNF_BlueBox].IntKeyPO
				,[CNF_BlueBox].BlueBoxNum
				,[CNF_BlueBox].BoxQuant
				,[CNF_BlueBox].CREATEDATE
				,[CNF_PO].POnum
				,[CNF_PO].SMVloc
				,[CNF_SKU].Variant
				,[CNF_SKU].ClrDesc
				,[CNF_STYLE].StyCod 
				,[CNF_BlueBox].Bagno
				FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO 
				FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY 
				FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY 
				WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
				'somevariable' => $inteosbbcode,
			));
			
			if ($inteos) {
				//continue
			} else {
	        	//$validator->errors()->add('field', 'Something is wrong with this field!');
	        	
	        	Log::error('Cannot find BB in Kikinda Inteos');
	        	$msg = 'Cannot find BB in Kikinda Inteos';
	        	return view('inteosdb.error', compact('msg'));
			}

		} else {

				Log::error('Cannot find BB in any Inteos');
	        	return view('inteosdb.error');
		
		}

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

		$BlueBoxCode = $inteosbbcode;
		//$InitKey = $inteos_array[0]['INTKEY'];
		$IntKeyPO =  $inteos_array[0]['IntKeyPO'];
		$BlueBoxNum =  $inteos_array[0]['BlueBoxNum'];
		$BoxQuant =  $inteos_array[0]['BoxQuant'];
		
		$BoxDateTemp =  $inteos_array[0]['CREATEDATE'];
		$timestamp = strtotime($BoxDateTemp);
		$BoxDate = date('Y-m-d H:i:s', $timestamp);
		//dd($BoxDate);
		
		// $POnum =  $inteos_array[0]['POnum'];
		$brcrtica = substr_count($inteos_array[0]['POnum'],"-");
		// echo $brcrtica." ";
		if ($brcrtica == 1) {
			list($one, $two) = explode('-', $inteos_array[0]['POnum']);
			$POnum = $one;
		} else {
			$POnum = $inteos_array[0]['POnum'];
		}

		$SMVloc =  $inteos_array[0]['SMVloc'];
		$Variant =  $inteos_array[0]['Variant'];
		$ClrDesc = $inteos_array[0]['ClrDesc'];
		$StyCod =  $inteos_array[0]['StyCod'];
		$Bagno =  $inteos_array[0]['Bagno'];
		
		// list($ColorCode, $Size) = explode('-', $Variant); 

		$brlinija = substr_count($Variant,"-");
		// echo $brlinija." ";

		if ($brlinija == 2) {
			list($ColorCode, $size1, $size2) = explode('-', $Variant);
			$Size = $size1."-".$size2;
			// echo $color." ".$size;	
		} else {
			list($ColorCode, $Size) = explode('-', $Variant);
			// echo $color." ".$size;
		}
	
		//return view('welcome', compact('bbstock', 'inteos'));
		//return view('welcome', compact('IntKeyPO', 'BlueBoxNum'));
		$QtyofBB = null;
		return view('inteosdb.create', compact('BlueBoxCode', 'BlueBoxNum', 'BoxQuant', 'BoxDate','POnum','SMVloc','Variant', 'ClrDesc', 'StyCod', 'ColorCode', 'Size', 'QtyofBB', 'Bagno' ));
	}

	public function create_bb(Request $request) {
		// dd("test");
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
			$po = $inteosinput['POnum'];
		}

		$po = substr($po,-6); //should I change this?

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

		// dd($QtyofBB);
		if ($QtyofBB == 0) {
			$msg = "Number of BB: must be different than 0.";
			return view('inteosdb.create', compact('BlueBoxCode', 'BlueBoxNum', 'BoxQuant', 'BoxDate','POnum','SMVloc', 'Variant', 'ClrDesc', 'StyCod', 'Bagno', 'ColorCode', 'Size', 'QtyofBB', 'msg' ));
		}

		$style_sap = str_pad($StyCod, 9); 
		$color_sap = str_pad($ColorCode, 4);
		$size_sap = str_pad($Size, 5);

		$sku = trim($style_sap.$color_sap.$size_sap);
		
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
	
}
