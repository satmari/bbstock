<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\bbStockPrepare;
use App\tempprepare;


use DB;
use Session;


class bbStockPrepareController extends Controller {

	public function index()
	{
		//
		// dd("Test");
		return view('prepare.index');
	}
	
	public function prepare($function)
	{
		
		// dd($function);
		return view('prepare.prepare_'.$function, compact('function'));
	}

	public function prepare_user(Request $request)
	{
		
		$input = $request->all(); 
		// dd($input);

		$function = $input['function'];
		$rnumber = $input['rnumber'];
		// dd($rnumber);

		$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT TOP 1 [Name]
		FROM [BdkCLZG].[dbo].[WEA_PersData]
		WHERE BadgeNum = '".$rnumber."' "));

		// dd($inteos[0]);

		if (empty($inteos) OR ($input['rnumber'] == "") ) {
			$msg = 'R number not exist in Inteos';
			return view('prepare.prepare_'.$function, compact('msg'));
		}

		// dd($inteos[0]->Name);
		$username = $inteos[0]->Name;

		$inteosdb = Session::get('inteosdb');
		// dd($inteosdb);

		if (is_null($inteosdb)) {
			// dd('yes');
			$inteosdb = 1;
		}
		Session::set('inteosdb', $inteosdb);


		//---------------------------------- FILL 
		if ($function == 'FILL') {
			return view('prepare.prepare_scan_fill', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray'));

		}

		$bbaddarray = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tempprepares WHERE
			f = '".$function."' AND rnumber = '".$rnumber."' "));

		return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray'));
	}

	public function prepare_scan(Request $request)
	{
		
		$input = $request->all(); // change use (delete or comment user Requestl; 
		// dd($input);

		$rnumber = $input['rnumber'];
		$username = $input['username'];
		$inteosdb = $input['inteosdb_new'];
		Session::set('inteosdb', $inteosdb);
		$inteosdb = Session::get('inteosdb');
		if (is_null($inteosdb)) {
			// dd('yes');
			$inteosdb = 1;
		}

		$function = $input['function'];
		$bb = $input['bb'];

		$bbaddarray = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tempprepares WHERE
		f = '".$function."' AND rnumber = '".$rnumber."' "));

		if ($inteosdb == '1') {

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT BlueBoxNum FROM [CNF_BlueBox] WHERE INTKEY =  :somevariable"), array(
				'somevariable' => $bb,
			));
			
			if ($inteos) {
				//continue
			} else {

	        	$msg = 'Cannot find BB in Subotica Inteos';
	        	return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
			}

		} elseif ($inteosdb == '2') {
			
			$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT BlueBoxNum FROM [CNF_BlueBox] WHERE INTKEY =  :somevariable"), array(
				'somevariable' => $bb,
			));

			if ($inteos) {
				//continue
			} else {

	        	$msg = 'Cannot find BB in Kikinda Inteos';
	        	return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
			}

		} else {
			$msg = 'BB not found';
			return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
		}

		// dd($inteos);
		
		try {
			$db = new tempprepare;
			$db->bbcode = $bb;
			$db->bbname = $inteos[0]->BlueBoxNum;
			$db->inteosdb = $inteosdb;
			$db->rnumber = $rnumber;
			$db->username = $username;
			$db->f = $function;

			$db->save();
			
		}
		catch (\Illuminate\Database\QueryException $e) {
			// $msg = 'Problem to save in db!';
        	// return view('prepare.error',compact('msg'));


			$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tempprepares WHERE bbname = '".$inteos[0]->BlueBoxNum."' "));
			//dd($bb);
			foreach ($bb as $b) {
				$bbid = $b->id;
			}

			$bbstockold = tempprepare::findOrFail($bbid);
			// dd($bb);
			// $bbstockold->delete();

			$bbstockold->bbcode = $b->bbcode;
			$bbstockold->bbname = $b->bbname;
			$bbstockold->inteosdb = $inteosdb;
			$bbstockold->rnumber = $rnumber;
			$bbstockold->username = $username;
			$bbstockold->f = $function;
			
			$bbstockold->save();
		}
		// dd("Done");


		$bbaddarray = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tempprepares WHERE
			f = '".$function."' AND rnumber = '".$rnumber."' "));

		return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function','bbaddarray'));
	}

	public function prepare_confirm(Request $request)
	{
		
		$input = $request->all(); 
		// dd($input);

		$rnumber = strtoupper($input['rnumber']);
		$username = $input['username'];
		$function = $input['function'];
		// dd($rnumber);

		$bbaddarray = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tempprepares WHERE
		f = '".$function."' AND rnumber = '".$rnumber."' "));

		$inteosdb = Session::get('inteosdb');

		if (empty($bbaddarray)) {
			// dd("Cao");
			//continue

			$msg = 'List to confirm is empty!';
			return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));

		} else {

			foreach ($bbaddarray as $bb) {
				
				// dd($bb->inteosdb);

				if ($bb->inteosdb == '1') {

					//with bagno
					$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].Bagno,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
						'somevariable' => $bb->bbcode,
					));
					
					if ($inteos) {
						//continue
					} else {

			        	$msg = 'Cannot find BB in Subotica Inteos';
			        	return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
					}

				} elseif ($bb->inteosdb == '2') {
					
					//with bagno
					$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].Bagno,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
						'somevariable' => $bb->bbcode,
					));

					if ($inteos) {
						//continue
					} else {

			        	$msg = 'Cannot find BB in Kikinda Inteos';
			        	return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
					}

				} else {
					$msg = 'BB not found';
					return view('prepare.prepare_scan', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
				}

				// dd($inteos);

				$Variant = $inteos[0]->Variant;

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

				// $qty = (int) $inteosdb[0]->BoxQuant;
				try {
					$db = new bbStockPrepare;
					$db->bbcode = $bb->bbcode;
					$db->bbname = $bb->bbname;
					$db->inteosdb = $bb->inteosdb;
					$db->rnumber = $rnumber;
					$db->username = $username;
					$db->f = $function;

					$db->po = $inteos[0]->POnum;
					$db->style = $inteos[0]->StyCod;
					$db->color = $ColorCode;
					$db->size =  $Size;
					$db->qty =  (int)$inteos[0]->BoxQuant;
					$db->bagno =  $inteos[0]->Bagno;

					$db->save();
					$db = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;DELETE FROM tempprepares WHERE rnumber = '".$rnumber."' AND f = '".$function."'; SELECT TOP 1 id FROM tempprepares"));

				}
				catch (\Illuminate\Database\QueryException $e) {	
				}

			}

		}

	return view('prepare.index');
	}


	public function prepare_scan_fill(Request $request) {

		$input = $request->all(); // change use (delete or comment user Requestl; 
		// dd($input);

		$rnumber = $input['rnumber'];
		$username = $input['username'];
		$inteosdb = $input['inteosdb_new'];
		Session::set('inteosdb', $inteosdb);
		$inteosdb = Session::get('inteosdb');
		if (is_null($inteosdb)) {
			// dd('yes');
			$inteosdb = 1;
		}

		$function = $input['function'];
		$bb = $input['bb'];

		/*
		$bbaddarray = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tempprepares WHERE
		f = '".$function."' AND rnumber = '".$rnumber."' "));
		*/

		if ($inteosdb == '1') {

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].Bagno,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
						'somevariable' => $bb,
			));
			
			if ($inteos) {
				//continue
			} else {

	        	$msg = 'Cannot find BB in Subotica Inteos';
	        	return view('prepare.prepare_scan_fill', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
			}

		} elseif ($inteosdb == '2') {
			
			$inteos = DB::connection('sqlsrv5')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].Bagno,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
						'somevariable' => $bb,
			));

			if ($inteos) {
				//continue
			} else {

	        	$msg = 'Cannot find BB in Kikinda Inteos';
	        	return view('prepare.prepare_scan_fill', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
			}

		} else {
			$msg = 'BB not found';
			return view('prepare.prepare_scan_fill', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
		}
		// dd($inteos);

		$Variant = $inteos[0]->Variant;

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


		$bbcode = $bb;
		$bbname = $inteos[0]->BlueBoxNum;
		$inteosdb = $inteosdb;
		$rnumber = $rnumber;
		$username = $username;
		$function = $function;

		$po = $inteos[0]->POnum;
		$style = $inteos[0]->StyCod;
		$color = $ColorCode;
		$size = $Size;
		$qty = $inteos[0]->BoxQuant;
		$bagno = $inteos[0]->Bagno;


		$operation;

		$operation_list = DB::connection('sqlsrv2')->select(DB::raw("SELECT
			--StyCod
			--,Variant
			OperDesc
			,OperCode
			--,*
		  FROM [BdkCLZG].[dbo].[CNF_SkuExtraOperations] as seo
		  JOIN [BdkCLZG].[dbo].[CNF_SKU] as sku ON sku.INTKEY = seo.SKUKEY
		  JOIN [BdkCLZG].[dbo].[CNF_STYLE] as s ON s.INTKEY = sku.STYKEY
		  JOIN [BdkCLZG].[dbo].[CNF_ExtraOperations] as eo ON eo.INTKEY = seo.EOPKEY
		  WHERE  StyCod = '".$style."' AND Variant = '".$Variant ."'
		  
		UNION 

		SELECT
			--StyCod
			--,Variant
			OperDesc
			,OperCode
			--,*
		  FROM [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_SkuExtraOperations] as seo
		  JOIN [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_SKU] as sku ON sku.INTKEY = seo.SKUKEY
		  JOIN [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_STYLE] as s ON s.INTKEY = sku.STYKEY
		  JOIN [SBT-SQLDB01P\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_ExtraOperations] as eo ON eo.INTKEY = seo.EOPKEY
		  WHERE  StyCod = '".$style."' AND Variant = '".$Variant ."'

		  "));

		// dd($operation_list[0]);

		$newarray = [];

		if (isset($operation_list[0])) {
			
			for ($i=0; $i < count($operation_list); $i++) { 

				array_push($newarray, array(
			        "operation" => $operation_list[$i]->OperDesc, 
			        "operation_code" => $operation_list[$i]->OperCode
			        
			    ));

			}	
		} else {

			$msg = 'Operations are not set for this SKU, operacije nisu unete za ovaj SKU.';
			return view('prepare.prepare_scan_fill', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
		}

		// dd($newarray);
		return view('prepare.prepare_scan_fill_confirm', compact('bbcode', 'bbname','inteosdb', 'rnumber', 'username', 'function', 'po', 'style', 'color', 'size', 'qty', 'bagno', 'Variant','newarray' ));

	}

	public function prepare_scan_fill_confirm(Request $request) {

		$input = $request->all(); // change use (delete or comment user Requestl; 
		// dd($input);

		$bbcode = $input['bbcode'];
		$bbname = $input['bbname'];
		$inteosdb = $input['inteosdb'];
		$rnumber = $input['rnumber'];
		$username = $input['username'];
		$function = $input['function'];

		$po = $input['po'];
		$style = $input['style'];
		$color = $input['color'];
		$size = $input['size'];
		$qty = $input['qty'];
		$bagno = $input['bagno'];

		$Variant = $input['Variant'];

		// dd($newarray);

		if (isset($input['operation_code'])) {
			$operations = $input['operation_code'];

		} else {

			$operation_list = DB::connection('sqlsrv2')->select(DB::raw("SELECT
				--StyCod
				--,Variant
				OperDesc
				,OperCode
				--,*
			  FROM [BdkCLZG].[dbo].[CNF_SkuExtraOperations] as seo
			  JOIN [BdkCLZG].[dbo].[CNF_SKU] as sku ON sku.INTKEY = seo.SKUKEY
			  JOIN [BdkCLZG].[dbo].[CNF_STYLE] as s ON s.INTKEY = sku.STYKEY
			  JOIN [BdkCLZG].[dbo].[CNF_ExtraOperations] as eo ON eo.INTKEY = seo.EOPKEY
			  WHERE  StyCod = '".$style."' AND Variant = '".$Variant ."'
			  ORDER BY s.StyCod, sku.Variant
			  "));

			// dd($operation_list[0]);

			$newarray = [];

			if (isset($operation_list[0])) {
				
				for ($i=0; $i < count($operation_list); $i++) { 

					array_push($newarray, array(
				        "operation" => $operation_list[$i]->OperDesc, 
				        "operation_code" => $operation_list[$i]->OperCode
				        
				    ));

				}	
			} else {

				$msg = 'Operations are not set for this SKU, operacije nisu unete za ovaj SKU.';
				return view('prepare.prepare_scan_fill', compact('rnumber', 'username', 'inteosdb', 'function', 'bbaddarray', 'msg'));
			}


			$warning = "Minimum jedna operacija mora biti slektovana";
			return view('prepare.prepare_scan_fill_confirm', compact('bbcode', 'bbname','inteosdb', 'rnumber', 'username', 'function', 'po', 'style', 'color', 'size', 'qty', 'bagno', 'Variant' ,'newarray', 'warning' ));
		}
		
		// dd($operation_code);

		for ($i=0; $i < count($operations); $i++) { 
			
			list($operation_code, $operation) = explode('#', $operations[$i]);
			// dd($operation_code);
			// dd($operation);



			try {
					$db = new bbStockPrepare;
					$db->bbcode = $bbcode;
					$db->bbname = $bbname;
					$db->inteosdb = $inteosdb;
					$db->rnumber = $rnumber;
					$db->username = $username;
					$db->f = $function;

					$db->po = $po;
					$db->style = $style;
					$db->color = $color;
					$db->size =  $size;
					$db->qty =  (int)$qty;
					$db->bagno =  $bagno;

					$db->operation =  $operation;
					$db->operation_code =  $operation_code;

					$db->save();
			

			}
				catch (\Illuminate\Database\QueryException $e) {	
					dd("Problem to save");
			}



		}

		return view('prepare.index');

	}

	public function prepare_table() {

		$batch = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bb_stock_prepares] ORDER BY created_at desc"));

	return view('prepare.table', compact('batch'));

	}

}
