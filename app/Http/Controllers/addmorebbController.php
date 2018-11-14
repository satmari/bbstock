<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\bb_stock_log;

use DB;
use Log;

use Session;

class addmorebbController extends Controller {


	public function index()
	{
		//
		$ses = Session::get('bb_to_add_array');
		return view('addmorebb.index',compact('ses'));
	}

	public function set_to_add(Request $request)
	{	
		//validation
		//$this->validate($request, ['bb_to_add'=>'required|max:10']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);
	
		$bbcode = $input['bb_to_add'];
		//$results = bbStock::where('bbcode', '=', $bb_to_remove)->delete();
		//dd($bbcode);
		$msg = '';

		if ($bbcode) {

			
			//$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT id,bbname,numofbb FROM bbStock WHERE bbcode = ".$bbcode));

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [BdkCLZG].[dbo].[CNF_BlueBox] FULL outer join [BdkCLZG].[dbo].CNF_PO on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [BdkCLZG].[dbo].[CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [BdkCLZG].[dbo].[CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
			'somevariable' => $bbcode,
			));
		

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
			
				Session::push('bb_to_add_array',$bbaddarray);
				// dd($bbaddarray);

			} else {
	        	//$validator->errors()->add('field', 'Something is wrong with this field!');
	        	
	        	// Log::error('Cannot find BB in Inteos');
	        	$msg = "Cannot find BB in Inteos";
	        	// return view('addmorebb.error', compact('msg'));
	    	}

				
		}

		$bbaddarray = Session::get('bb_to_add_array');
		//dd($bbaddarray);

		if ($bbaddarray != null) {

			$bbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));
			// dd($bbaddarray_unique);

			$sumofbb =0;
			foreach ($bbaddarray_unique as $line) {
				foreach ($line as $key => $value) {
					if ($key == 'BlueBoxCode') {
						$sumofbb+=1;
					}
				}
			}
			// Session::push('bb_to_add_array',$bbaddarray_unique); // dodato sada
		}

		return view('addmorebb.index',compact('bbaddarray_unique','sumofbb','msg'));
	}

	public function addbbloc(Request $request)
	{

		$bbaddarray = Session::get('bb_to_add_array');
		//dd($bbaddarray);

		if (isset($bbaddarray)) {

			return view('addmorebb.addloc');

		} else {
		
		$msg = "List of BB to add is empty";
		return view('addmorebb.success',compact('msg'));

		}

	}

	public function addbbsave(Request $request)
	{	

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);

		$location = $input['location'];
		// dd($location);

		$bbaddarray = Session::get('bb_to_add_array');
		//dd($bbaddarray);
		
		

		//dd($bbaddarray_unique);
		if (isset($bbaddarray)) {

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
				$numofbb = 1;

				$location = $location ; // NEAMA !!!!!!!!!!!

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

				// return view('bbstock.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
						
			}

			Session::set('bb_to_add_array', null);
			$msg = "All scanned BB succesfuly add to BBStock";
			return view('addmorebb.success',compact('msg'));
		}

		Session::set('bb_to_add_array', null);
		$msg = "List of BB to add is empty";
		return view('addmorebb.success',compact('msg'));
		
	}


}
