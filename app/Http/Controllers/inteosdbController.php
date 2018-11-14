<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Request;

use App\bbStock;

use DB;
use Log;

class inteosdbController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()	{

        //return view('bbstock.index', compact('bbstock'));
        return view('inteosdb.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		//
		$this->validate($request, ['inteos_bb_code' => 'required|max:10']);

		$inteosinput = $request->all(); // change use (delete or comment user Requestl; )
		//1971107960

		$inteosbbcode = $inteosinput['inteos_bb_code'];
		//var_dump($inteosbb);
		
		//$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT IntKeyPO,BlueBoxNum,BoxQuant FROM [BdkCLZGtest].[dbo].[CNF_BlueBox] WHERE INTKEY = 56013339 "), array());
		// Test database
		/*$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant, [CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [BdkCLZGtest].[dbo].[CNF_BlueBox] FULL outer join [BdkCLZGtest].[dbo].CNF_PO on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [BdkCLZGtest].[dbo].[CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [BdkCLZGtest].[dbo].[CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
			'somevariable' => $inteosbbcode,
		));*/
		// Live database
		$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [BdkCLZG].[dbo].[CNF_BlueBox] FULL outer join [BdkCLZG].[dbo].CNF_PO on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [BdkCLZG].[dbo].[CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [BdkCLZG].[dbo].[CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
			'somevariable' => $inteosbbcode,
		));
		
		if ($inteos) {
			//continue
		} else {
        	//$validator->errors()->add('field', 'Something is wrong with this field!');
        	
        	Log::error('Cannot find BB in Inteos');
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
		return view('inteosdb.create', compact('BlueBoxCode', 'BlueBoxNum', 'BoxQuant', 'BoxDate','POnum', 'Variant', 'ClrDesc', 'StyCod', 'ColorCode', 'Size' ));
	}

	
}
