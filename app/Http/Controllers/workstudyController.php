<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\bbStock;

use DB;
use Log;


class workstudyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view('workstudy.scan_bb');
	}

	public function scan_bb(Request $request)
	{
		//
		$this->validate($request, ['inteos_bb_code' => 'required|max:10']);

		$inteosinput = $request->all(); // change use (delete or comment user Requestl; )
		//1971107960

		$inteosbbcode = $inteosinput['inteos_bb_code'];
		// dd($inteosbbcode);
		
		// Live database
		// $inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [BdkCLZG].[dbo].[CNF_BlueBox] FULL outer join [BdkCLZG].[dbo].CNF_PO on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [BdkCLZG].[dbo].[CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [BdkCLZG].[dbo].[CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
		// 	'somevariable' => $inteosbbcode,
		// ));

		$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT	bb.INTKEY,
					bb.IntKeyPO,
					bb.BlueBoxNum,
					bb.BoxQuant,
					bb.CREATEDATE,
					po.POnum,
					--po.SMVloc as smv,
					sku.Variant,
					sku.ClrDesc,
					s.StyCod
			FROM [BdkCLZG].[dbo].[CNF_BlueBox] as bb
			FULL outer join [BdkCLZG].[dbo].[CNF_PO] as po on po.INTKEY = bb.IntKeyPO
			FULL outer join [BdkCLZG].[dbo].[CNF_SKU] as sku on sku.INTKEY = po.SKUKEY 
			FULL outer join [BdkCLZG].[dbo].[CNF_STYLE] as s on s.INTKEY = sku.STYKEY 
			WHERE bb.INTKEY = '".$inteosbbcode."'
			UNION ALL
			SELECT	bb.INTKEY,
					bb.IntKeyPO,
					bb.BlueBoxNum,
					bb.BoxQuant,
					bb.CREATEDATE,
					po.POnum,
					--po.SMVloc as smv,
					sku.Variant,
					sku.ClrDesc,
					s.StyCod
			FROM [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox] as bb
			FULL outer join [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] as po on po.INTKEY = bb.IntKeyPO
			FULL outer join [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_SKU] as sku on sku.INTKEY = po.SKUKEY 
			FULL outer join [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_STYLE] as s on s.INTKEY = sku.STYKEY 
			WHERE bb.INTKEY = '".$inteosbbcode."' "));


		
		if ($inteos) {
			//continue
		} else {
        	//$validator->errors()->add('field', 'Something is wrong with this field!');
        	
        	$msg = 'Cannot find BB in Inteos';
        	return view('workstudy.error', compact('msg'));
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
		// dd($BoxDate);
		$POnum =  $inteos_array[0]['POnum'];
		$Variant =  $inteos_array[0]['Variant'];
		$ClrDesc = $inteos_array[0]['ClrDesc'];
		$StyCod =  $inteos_array[0]['StyCod'];
		
		// list($ColorCode, $Size) = explode('-', $Variant); 

		$brlinija = substr_count($Variant,"-");
			// echo $brlinija." ";

			if ($brlinija == 2)
			{
				list($ColorCode, $size1, $size2) = explode('-', $Variant);
				$Size = $size1."-".$size2;
				// echo $color." ".$size;	
			} else {
				list($ColorCode, $Size) = explode('-', $Variant);
				// echo $color." ".$size;
			}


	
		//return view('welcome', compact('bbstock', 'inteos'));
		//return view('welcome', compact('IntKeyPO', 'BlueBoxNum'));
		return view('workstudy.create', compact('BlueBoxCode', 'BlueBoxNum', 'BoxQuant', 'BoxDate','POnum', 'Variant', 'ClrDesc', 'StyCod', 'ColorCode', 'Size' ));
	}

	public function create(Request $request) {
		//
		//validation
		$this->validate($request, ['BlueBoxCode'=>'required','QtyofBB'=>'required']);

		$inteosinput = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		$bbcode = $inteosinput['BlueBoxCode'];
		$bbname = $inteosinput['BlueBoxNum'];
		//$po = $inteosinput['POnum'];
		$po = substr($inteosinput['POnum'], -6); 
		$style = $inteosinput['StyCod'];
		$color = $inteosinput['ColorCode'];
		$size = $inteosinput['Size'];
		$qty = $inteosinput['BoxQuant'];
		$boxdate = $inteosinput['BoxDate'];
		$numofbb = $inteosinput['QtyofBB'];

		if ($inteosinput['BBLocation_row'] == "") {
			$msg = "Niste uneli red modula.";
			return view('workstudy.error', compact('msg'));

		}

		if ($inteosinput['BBLocation_module'] == "") {
			$msg = "Niste uneli ime modula.";
			return view('workstudy.error', compact('msg'));
		}

		// dd($inteosinput['BBLocation_row']);
		$location_row = $inteosinput['BBLocation_row'];
		$location_module = $inteosinput['BBLocation_module'];

		$location = $location_row." ".$location_module;
		

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
		
		return view('workstudy.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
	}

}
