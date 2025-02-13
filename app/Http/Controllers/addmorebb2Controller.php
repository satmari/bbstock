<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\bb_stock_log;
use App\bbStock_extra;

use DB;
use Log;

use Session;

class addmorebb2Controller extends Controller {

	public function index() {
		//
		// $ses = Session::get('bb_to_add_array');
		$ses = Session::set('bb_to_add_array',null);
		$inteosdb = Session::get('inteosdb');

		if (is_null($inteosdb)) {
        	$inteosdb = '1';
        }
        
        return view('addmorebb2.index',compact('ses', 'inteosdb'));
	}

	public function set_to_add(Request $request) {	
		//validation
		//$this->validate($request, ['bb_to_add'=>'required|max:10']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);
	
		$bbcode = $input['bb_to_add'];
		$inteosdb = $input['inteosdb_new'];
		Session::set('inteosdb', $inteosdb );

		$bbaddarray_unique = Session::get('bb_to_add_array');

		//$results = bbStock::where('bbcode', '=', $bb_to_remove)->delete();
		//dd($bbcode);
		$msg = '';

		if ($bbcode) {

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
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
					//continue
				} else {
		        	// $validator->errors()->add('field', 'Something is wrong with this field!');
		        	
		        	Log::error('Cannot find BB in Subotica or Senta Inteos');
		        	$msg = 'Cannot find BB in Subotica or Senta Inteos';
		        	return view('addmorebb2.index',compact('bbaddarray_unique','sumofbb','msg','inteosdb'));
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
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
					//continue
				} else {
		        	//$validator->errors()->add('field', 'Something is wrong with this field!');
		        	
		        	Log::error('Cannot find BB in Kikinda Inteos');
		        	$msg = 'Cannot find BB in Kikinda Inteos';
		        	return view('addmorebb2.index',compact('bbaddarray_unique','sumofbb','msg','inteosdb'));

				}

			} else {

					Log::error('Cannot find BB in any Inteos');
					$msg = 'Cannot find BB in any Inteos';
		        	return view('addmorebb2.index',compact('bbaddarray_unique','sumofbb','msg','inteosdb'));
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
				if (isset($inteos_array[0]['IntKeyPO'])) {
					$IntKeyPO =  $inteos_array[0]['IntKeyPO'];	
				} else {
					$IntKeyPO =  '';
				}
				
				$SMVloc =  $inteos_array[0]['SMVloc'];
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

				$bbaddarray = array(
					'BlueBoxCode' => $bbcode,
					'BlueBoxNum' => $BlueBoxNum,
					'BoxQuant' => $BoxQuant,
					'BoxDate' => $BoxDate,
					// 'IntKeyPO' => $IntKeyPO,
					'POnum' => $POnum,
					'SMVloc' => $SMVloc,
					// 'BoxDateTemp' => $BoxDateTemp,
					'Variant' => $Variant,
					'ClrDesc' => $ClrDesc,
					'StyCod' => $StyCod,
					'ColorCode' => $ColorCode,
					'Size' => $Size,
					'Bagno' => $Bagno
				);
				// dd($bbaddarray);
			
				Session::push('bb_to_add_array',$bbaddarray);
				// dd($bbaddarray);

			} else {
	        	//$validator->errors()->add('field', 'Something is wrong with this field!');
	        	
	        	// Log::error('Cannot find BB in Inteos');
	        	$msg = "Cannot find BB in Inteos";
	        	// return view('addmorebb2.error', compact('msg'));
	    	}		
		}

		$bbaddarray = Session::get('bb_to_add_array');
		//dd($bbaddarray);
		$sumofbb = 0;
		if ($bbaddarray != null) {

			$bbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));
			// dd($bbaddarray_unique);

			$sumofbb = 0;
			foreach ($bbaddarray_unique as $line) {
				foreach ($line as $key => $value) {
					if ($key == 'BlueBoxCode') {
						$sumofbb+=1;
					}
				}
			}
			// Session::push('bb_to_add_array',$bbaddarray_unique); // dodato sada
		}

		return view('addmorebb2.index',compact('bbaddarray_unique','sumofbb','msg','inteosdb'));
	}

	public function removebb_from_list ($bbcode) {
		// dd($bbcode);

		$bbaddarray = Session::get('bb_to_add_array');
		$inteosdb = Session::get('inteosdb');
		// var_dump($bbaddarray);
		// dd($bbaddarray);
		
		$bbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));

		// Iterate through the array
		foreach ($bbaddarray_unique as $key => $item) {
		    // Check if the "BlueBoxCode" is equal to "907356731"
		    if ($item["BlueBoxCode"] === $bbcode) {
		        // Remove the array from the original array
		        unset($bbaddarray_unique[$key]);
		    }
		}

		// Re-index the array after unsetting elements
		// $yourArray = array_values($yourArray);

		// dd($bbaddarray_unique);
		Session::set('bb_to_add_array', $bbaddarray_unique);
		$bbaddarray = Session::get('bb_to_add_array');

		$sumofbb = 0;
		if ($bbaddarray != null) {

			$bbaddarray_unique = array_map("unserialize", array_unique(array_map("serialize", $bbaddarray)));
			// dd($bbaddarray_unique);

			$sumofbb = 0;
			foreach ($bbaddarray_unique as $line) {
				foreach ($line as $key => $value) {
					if ($key == 'BlueBoxCode') {
						$sumofbb+=1;
					}
				}
			}
			// Session::push('bb_to_add_array',$bbaddarray_unique); // dodato sada
		}
		// dd($bbaddarray_unique);

		$msg = 'BB removed from the list';
		return view('addmorebb2.index',compact('bbaddarray_unique','sumofbb','msg','inteosdb'));
	}

	public function addbbloc(Request $request) {

		$bbaddarray = Session::get('bb_to_add_array');
		$inteosdb = Session::get('inteosdb');
		//dd($bbaddarray);

		if (isset($bbaddarray)) {
			return view('addmorebb2.addloc');

		} else {
			
			$msg = 'List of BB is empty';
			return view('addmorebb2.index',compact('msg','inteosdb'));
		}
	}

	public function addbbsave(Request $request) { 

		$input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);

		$location = strtoupper($input['location']);
		// $inteosdb = Session::get('inteosdb');
		// dd($location);

		$loc = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM locations WHERE location = '".$location."' and (location_type = 'STOCK' or location_type = 'RECEIVING')"));
		if (!isset($loc[0]->id)) {
			$msg = "Scaned location does not exist or it is not STOCK or RECEIVING location type.";
			return view('addmorebb2.addloc', compact('msg'));
		}

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
				$qty = $line['BoxQuant'];
				$boxdate = $line['BoxDate'];

				$brcrtica = substr_count($line['POnum'],"-");
				// echo $brcrtica." ";
				if ($brcrtica == 1)
				{
					list($one, $two) = explode('-', $line['POnum']);
					$po = $one;
				} else {
					$po = $line['POnum'];
				}
				$po = substr($po,-6); //should I change this?

				$smv = $line['SMVloc'];
				$variant = $line['Variant'];
				$color_desc = $line['ClrDesc'];
				$style = $line['StyCod'];
				$color = $line['ColorCode'];
				$size = $line['Size'];
				$bagno = $line['Bagno'];
				
				$numofbb = 1;
				$location = $location; 
				$status = "STOCK";

				$style_sap = str_pad($style, 9); 
				$color_sap = str_pad($color, 4);
				$size_sap = str_pad($size, 5);

				$sku = trim($style_sap.$color_sap.$size_sap);


				// new check EXTRA
					// SKU
					$check_bb_has_extras = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM [bbStock_extras] WHERE bbcode = '".$bbcode."' and active = 1"));
					if (isset($check_bb_has_extras[0]->id)) {
						// skip extra operations
					} else {
						// add extra operations
						$check_sku = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [extra_skus] WHERE sku = '".$sku."' and active = 1 "));
						if (isset($check_sku[0]->id)) {
							// sku found
							// var_dump("sku found");

							// delete (set not active) all existing extras for bb (if exist)
							// $set_not_active = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras WHERE bbname = '".$bbname."' and extra = '".$check_sku->extra."' "));

							// add/update extra
							foreach ($check_sku as $line) {
								
								try {
									$bbStock_extra = new bbStock_extra;

									$bbStock_extra->bbcode = $bbcode;
									$bbStock_extra->bbname = $bbname;
									$bbStock_extra->operation = $line->operation;
									$bbStock_extra->operation_id = $line->operation_id;
									$bbStock_extra->operation_type = "sku";
									$bbStock_extra->key = $line->key."_".$bbStock_extra->code;
									$bbStock_extra->status = "NOT DONE";
									$bbStock_extra->active = 1;
									$bbStock_extra->save();
								}
								catch (\Illuminate\Database\QueryException $e) {
									
									// $update = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras WHERE bbname = '".$bbname."' and extra = '".$line->extra."' "));
									// //dd($bb);
									// foreach ($update as $b) {
									// 	$bbid = $b->id;
									// }
									
									// $bbStock_extraold = bbStock_extra::findOrFail($bbid);
									// $bbStock_extraold->bbcode = $bbcode;
									// $bbStock_extraold->bbname = $bbname;
									// $bbStock_extraold->extra = $line->extra;
									// $bbStock_extraold->key = $line->key."_".$bbStock_extra->bbname;
									// $bbStock_extraold->status = "NOT DONE";
									// $bbStock_extraold->active = 1;
									// $bbStock_extraold->save();
								}
							}

						} else {
							// STYLE SIZE
							$style_size = trim($style_sap)." ".trim($size_sap);
							$check_style_size = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [extra_style_sizes] WHERE style_size = '".$style_size."' and active = 1 "));

							if (isset($check_style_size[0]->id)) {
								// style_size found
								// var_dump("style_size found");

								// delete (set not active) all existing extras for bb (if exist)

								foreach ($check_style_size as $line) {
								
									try {
										$bbStock_extra = new bbStock_extra;

										$bbStock_extra->bbcode = $bbcode;
										$bbStock_extra->bbname = $bbname;
										$bbStock_extra->operation = $line->operation;
										$bbStock_extra->operation_id = $line->operation_id;
										$bbStock_extra->operation_type = "style_size";
										$bbStock_extra->key = $line->key."_".$bbStock_extra->bbcode;
										$bbStock_extra->status = "NOT DONE";
										$bbStock_extra->active = 1;
										$bbStock_extra->save();
									}
									catch (\Illuminate\Database\QueryException $e) {
										
										// $update = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras WHERE bbname = '".$bbname."' and extra = '".$line->extra."' "));
										// // dd($update);
										// foreach ($update as $b) {
										// 	$bbid = $b->id;
										// }
										
										// $bbStock_extraold = bbStock_extra::findOrFail($bbid);
										// $bbStock_extraold->bbcode = $bbcode;
										// $bbStock_extraold->bbname = $bbname;
										// $bbStock_extraold->extra = $line->extra;
										// $bbStock_extraold->key = $line->key."_".$bbStock_extra->bbname;
										// $bbStock_extraold->status = "NOT DONE";
										// $bbStock_extraold->active = 1;
										// $bbStock_extraold->save();
									}
								}

							} else {
								// STYLE
								$style = trim($style_sap);
								// dd($style);
								$check_style = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [extra_styles] WHERE style = '".$style."' and active = 1 "));
								// dd($check_style);

								if (isset($check_style[0]->id)) {
									// style found
									// var_dump("style found");

									// delete (set not active) all existing extras for bb (if exist)

									foreach ($check_style as $line) {
										
										try {
											$bbStock_extra = new bbStock_extra;

											$bbStock_extra->bbcode = $bbcode;
											$bbStock_extra->bbname = $bbname;
											$bbStock_extra->operation = $line->operation;
											$bbStock_extra->operation_id = $line->operation_id;
											$bbStock_extra->operation_type = "style";
											$bbStock_extra->key = $line->key."_".$bbStock_extra->bbcode;
											$bbStock_extra->status = "NOT DONE";
											$bbStock_extra->active = 1;
											$bbStock_extra->save();
										
										}
										catch (\Illuminate\Database\QueryException $e) {
											
										// 	$update = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras WHERE bbname = '".$bbname."' and extra = '".$line->extra."' "));
										// 	// dd($update);
										// 	foreach ($update as $b) {
										// 		$bbid = $b->id;
										// 	}
											
										// 	$bbStock_extraold = bbStock_extra::findOrFail($bbid);
										// 	$bbStock_extraold->bbcode = $bbcode;
										// 	$bbStock_extraold->bbname = $bbname;
										// 	$bbStock_extraold->extra = $line->extra;
										// 	$bbStock_extraold->key = $line->key."_".$bbStock_extra->bbname;
										// 	$bbStock_extraold->status = "NOT DONE";
										// 	$bbStock_extraold->active = 1;
										// 	$bbStock_extraold->save();
										}
										
									}
								} else {
									
									// var_dump("extra not found");
								}
							}	
						}
					
					}
				//

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
					$bbStock->bagno = $bagno;
					$bbStock->sku = $sku;
					// $bbStock->save();
				}
				catch (\Illuminate\Database\QueryException $e) {
					
					
					//return view('bbstock.error');		
					
					$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE bbname = '".$bbname."'"));
					//dd($bb);
					foreach ($bb as $b) {
						$bbid = $b->id;
					}

					$bbStock = bbStock::findOrFail($bbid);
					// dd($bb);
					// $bbstockold->delete();

					// $bbStock = new bbStock;
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
					$bbStock->bagno = $bagno;
					$bbStock->sku = $sku;
					// $bbStock->save();
				}
				// return view('bbstock.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			}

			Session::set('bb_to_add_array', null);
			$msg = "All scanned BBs succesfuly added to BBStock";
			return view('addmorebb2.success',compact('msg'));
		}

		Session::set('bb_to_add_array', null);
		$msg = "List of BB to add is empty";
		return view('addmorebb2.success',compact('msg'));
	}
}
