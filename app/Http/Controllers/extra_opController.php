<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\extra_sku;
use App\extra_style_size;
use App\extra_style;
use App\extra_op;
use App\bbStock_extra;

use DB;

class extra_opController extends Controller {

// SKU
	public function extra_sku() {
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_skus ORDER BY style, color, size  asc"));
		return view('extra_sku.index', compact('data'));
	}

	public function extra_sku_new() {
		//

		$operation_list = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops WHERE active = '1' ORDER BY id asc "));
		// dd($operation_list);
		return view('extra_sku.create', compact('operation_list'));	
	}

	public function extra_sku_insert(Request $request) {
		//
		$this->validate($request, ['style'=>'required','color'=>'required','size'=>'required','operation_id'=>'required']);

		$input = $request->all(); 
		
		$style = trim(strtoupper($input['style']));
		if (strlen($style) > 9 ) {
			dd('Stlye can not be more than 9 chars');
		}
		$color = trim(strtoupper($input['color']));
		if (strlen($color) > 4 ) {
			dd('Color can not be more than 4 chars');
		}
		$size = trim(strtoupper($input['size']));
		if (strlen($size) > 5 ) {
			dd('Size can not be more than 5 chars');
		}

		$sku = trim(str_pad($style,9,' ').str_pad($color,4,' ').str_pad($size,5,' '));
		// dd($sku);
		// dd(trim($sku));

		$operation_id = $input['operation_id'];
		$operation = extra_op::findOrFail($operation_id);
		$operation = $operation->operation;
		// dd($operation);
		$key = $sku."_".$operation_id;
		// dd($key);

		$old_operation_id = $operation_id;

		// check if already exist key
		$check = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_skus WHERE [key] = '".$key."' "));
		// dd($check);

		if (isset($check[0]->id)) {
			// dd("Combination of SKU and operation already exist");
		}

		try {
			$db = new extra_sku;
			$db->style = $style;
			$db->color = $color;
			$db->size = $size;
			$db->sku = $sku;
			$db->operation_id = $operation_id;
			$db->operation = $operation;
			$db->key = $key;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			// return view('extra_sku.error');			
			$db = extra_sku::findOrFail($check[0]->id);	
			$db->active = 1;
			$db->save();
		}

		// additional check
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' and b.[size] = '".$size."' and b.[color] = '".$color."' "));
			// dd($check_bb);
			
			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."'"));
				// dd($if_exist_extra);

				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'style') {

							$db = bbStock_extra::findOrFail($extra->id);
							$status = $db->status;
							$db->delete();

							try {
								$bbStock_extra = new bbStock_extra;
								$bbStock_extra->bbcode = $line->bbcode;
								$bbStock_extra->bbname = $line->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "sku";
								$bbStock_extra->key = $key."_".$line->bbcode;
								$bbStock_extra->status = $status;
								$bbStock_extra->active = 1;
								$bbStock_extra->save();
							}
							catch (\Illuminate\Database\QueryException $e) {
								// return view('extra_style.error');			
							}
						}
						if ($existing_operation_type == 'style_size') {

							$db = bbStock_extra::findOrFail($extra->id);
							$status = $db->status;
							$db->delete();

							try {
								$bbStock_extra = new bbStock_extra;
								$bbStock_extra->bbcode = $line->bbcode;
								$bbStock_extra->bbname = $line->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "sku";
								$bbStock_extra->key = $key."_".$line->bbcode;
								$bbStock_extra->status = $status;
								$bbStock_extra->active = 1;
								$bbStock_extra->save();
							}
							catch (\Illuminate\Database\QueryException $e) {
								// return view('extra_style.error');			
							}

						}
						if ($existing_operation_type == 'sku') {

							if (isset($status)) {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->status = $status;
								$db->active = 1;
								$db->save();	
							} else {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->active = 1;
								$db->save();
							}	
						} 
					}
					
				} else {
					// not exist in extra

					try {
						$bbStock_extra = new bbStock_extra;
						$bbStock_extra->bbcode = $line->bbcode;
						$bbStock_extra->bbname = $line->bbname;
						$bbStock_extra->operation = $operation;
						$bbStock_extra->operation_id = $operation_id;
						$bbStock_extra->operation_type = "sku";
						$bbStock_extra->key = $key."_".$line->bbcode;
						$bbStock_extra->status = "NOT DONE";
						$bbStock_extra->active = 1;
						$bbStock_extra->save();

					}
					catch (\Illuminate\Database\QueryException $e) {
						// return view('extra_style.error');			
						
					}
				}
			}
		// close 

		return Redirect::to('extra_sku');
	}

	public function extra_sku_edit($id) {
		// dd($id);
		$data = extra_sku::findOrFail($id);	
		$operation_list = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops WHERE active = '1' ORDER BY id asc "));
		
		return view('extra_sku.edit', compact('data','operation_list'));
	}

	public function extra_sku_update(Request $request) {
		//
		$this->validate($request, ['style'=>'required','color'=>'required','size'=>'required','operation_id'=>'required']);
		$input = $request->all(); 

		$style = trim(strtoupper($input['style']));
		if (strlen($style) > 9 ) {
			dd('Stlye can not be more than 9 chars');
		}
		$color = trim(strtoupper($input['color']));
		if (strlen($color) > 4 ) {
			dd('Color can not be more than 4 chars');
		}
		$size = trim(strtoupper($input['size']));
		if (strlen($size) > 5 ) {
			dd('Size can not be more than 5 chars');
		}

		$sku = trim(str_pad($style,9,' ').str_pad($color,4,' ').str_pad($size,5,' '));
		// dd($sku);
		// dd(trim($sku));

		$operation_id = $input['operation_id'];
		$operation = extra_op::findOrFail($operation_id);
		$operation = $operation->operation;
		// dd($operation);

		$key = $sku."_".$operation_id;

		try {
			
			$db = extra_sku::findOrFail($input['id']);
			$db->style = $style;
			$db->color = $color;
			$db->size = $size;
			$db->sku = $sku;
			$old_operation_id = $operation_id;
			// dd($old_operation_id);
			$db->operation_id = $operation_id;
			$db->operation = $operation;
			$db->key = $key;
			$db->save();

		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd("Combination of SKU and opearation already exist");
			// return view('extra_sku.error');
		}

		// additional check
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' AND b.[size] = '".$size."' AND b.[color] = '".$color."' "));
			// dd($check_bb);
			
			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."' "));
				// dd($if_exist_extra);
				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						$old_operation_id;
						$operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'style') {

							$db = bbStock_extra::findOrFail($extra->id);
							$status = $db->status;
							$db->delete();

							try {
								$bbStock_extra = new bbStock_extra;
								$bbStock_extra->bbcode = $line->bbcode;
								$bbStock_extra->bbname = $line->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "sku";
								$bbStock_extra->key = $key."_".$line->bbcode;
								$bbStock_extra->status = $status;
								$bbStock_extra->active = 1;
								$bbStock_extra->save();

							}
							catch (\Illuminate\Database\QueryException $e) {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->active = 1;
								$db->save();
							}
						}
						if ($existing_operation_type == 'style_size') {

							$db = bbStock_extra::findOrFail($extra->id);
							$status = $db->status;
							$db->delete();

							try {
								$bbStock_extra = new bbStock_extra;
								$bbStock_extra->bbcode = $line->bbcode;
								$bbStock_extra->bbname = $line->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "sku";
								$bbStock_extra->key = $key."_".$line->bbcode;
								$bbStock_extra->status = $status;
								$bbStock_extra->active = 1;
								$bbStock_extra->save();

							}
							catch (\Illuminate\Database\QueryException $e) {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->active = 1;
								$db->save();
							}
						}
						if ($existing_operation_type == 'sku') {

							$db = bbStock_extra::findOrFail($extra->id);
							$db->bbcode = $line->bbcode;
							$db->bbname = $line->bbname;
							$db->operation = $operation;
							$db->operation_id = $operation_id;
							$db->operation_type = "sku";
							$db->key = $key."_".$line->bbcode;
							// $db->status = "NOT DONE";  // status from previous operation
							$db->active = 1;
							$db->save();
						} 
					}
					
				} else {
					// not exist in extra

					try {
						$bbStock_extra = new bbStock_extra;
						$bbStock_extra->bbcode = $line->bbcode;
						$bbStock_extra->bbname = $line->bbname;
						$bbStock_extra->operation = $operation;
						$bbStock_extra->operation_id = $operation_id;
						$bbStock_extra->operation_type = "sku";
						$bbStock_extra->key = $key."_".$line->bbcode;
						$bbStock_extra->status = "NOT DONE";
						$bbStock_extra->active = 1;
						$bbStock_extra->save();
					}
					catch (\Illuminate\Database\QueryException $e) {
						// return view('extra_style.error');			
					}
				}


			}

		// close 
		
		return Redirect::to('/extra_sku');
	}

	public function extra_sku_view($operation_id, $sku) {

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras WHERE [key] like '".$sku."_".$operation_id."%' AND operation_type = 'sku' /*AND active = '1'*/ ORDER BY id asc "));
		// dd($data);
		return view('extra_sku.view', compact('data'));
	}

	public function extra_sku_delete($id) {

		$db = extra_sku::findOrFail($id);
		
		try {
			$db->active = 0;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('extra_sku.error');			
		}

		return Redirect::to('/extra_sku');
	}

// STYLE SIZE
	public function extra_style_size() {
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_style_sizes ORDER BY style  asc"));
		// dd($data);
		return view('extra_style_size.index', compact('data'));
	}

	public function extra_style_size_new() {
		//
		$operation_list = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops WHERE active = '1' ORDER BY id asc "));
		// dd($operation_list);
		return view('extra_style_size.create', compact('operation_list'));
	}

	public function extra_style_size_insert(Request $request) {
		//
		$this->validate($request, ['style'=>'required','size'=>'required','operation_id'=>'required']);

		$input = $request->all(); 
		
		$style = trim(strtoupper($input['style']));
		if (strlen($style) > 9 ) {
			dd('Stlye can not be more than 9 chars');
		}
		
		$size = trim(strtoupper($input['size']));
		if (strlen($size) > 5 ) {
			dd('Size can not be more than 5 chars');
		}
		
		$style_size = $style." ".$size;

		$operation_id = $input['operation_id'];
		$operation = extra_op::findOrFail($operation_id);
		$operation = $operation->operation;
		// dd($operation);

		$old_operation_id = $operation_id;

		$key = $style_size."_".$operation_id;

		// check if already exist key
		$check = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_style_sizes WHERE [key] = '".$key."' "));
		// dd($check);

		if (isset($check[0]->id)) {
			// dd("Combination of style_size and operation already exist");
		}

		try {
			$db = new extra_style_size;

			$db->style = $style;
			$db->size = $size;
			$db->style_size = $style_size;
			$db->operation_id = $operation_id;
			$db->operation = $operation;
			$db->key = $key;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			
			$db = extra_style_size::findOrFail($check[0]->id);	
			$db->active = 1;
			$db->save();
		}

		// additional check
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' and b.[size] = '".$size."' "));
			// dd($check_bb);
			
			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."'"));
				// dd($if_exist_extra);

				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'style') {

							$db = bbStock_extra::findOrFail($extra->id);
							$status = $db->status;
							$db->delete();

							try {
								$bbStock_extra = new bbStock_extra;
								$bbStock_extra->bbcode = $line->bbcode;
								$bbStock_extra->bbname = $line->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "style_size";
								$bbStock_extra->key = $key."_".$line->bbcode;
								$bbStock_extra->status = $status;
								$bbStock_extra->active = 1;
								$bbStock_extra->save();

							}
							catch (\Illuminate\Database\QueryException $e) {
								// return view('extra_style.error');			
							}
						}
						if ($existing_operation_type == 'style_size') {

							if (isset($status)) {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->status = $status;
								$db->active = 1;
								$db->save();	
							} else {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->active = 1;
								$db->save();
							}

						}
						if ($existing_operation_type == 'sku') {
							
						} 
					}
					
				} else {
					// not exist in extra

					try {
						$bbStock_extra = new bbStock_extra;
						$bbStock_extra->bbcode = $line->bbcode;
						$bbStock_extra->bbname = $line->bbname;
						$bbStock_extra->operation = $operation;
						$bbStock_extra->operation_id = $operation_id;
						$bbStock_extra->operation_type = "style_size";
						$bbStock_extra->key = $key."_".$line->bbcode;
						$bbStock_extra->status = "NOT DONE";
						$bbStock_extra->active = 1;
						$bbStock_extra->save();

					}
					catch (\Illuminate\Database\QueryException $e) {
						// return view('extra_style.error');			
						
					}
				}
				
			}
			
		// close 

		return Redirect::to('extra_style_size');
	}

	public function extra_style_size_edit($id) {
		// dd($id);
		$data = extra_style_size::findOrFail($id);	
		$operation_list = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops WHERE active = '1' ORDER BY id asc "));
		// dd($operation_list);
		
		return view('extra_style_size.edit', compact('data', 'operation_list'));
	}

	public function extra_style_size_update(Request $request) {
		//
		$this->validate($request, ['style'=>'required','size'=>'required','operation_id'=>'required']);

		$input = $request->all(); 
		// dd($input);

		$style = trim(strtoupper($input['style']));
		if (strlen($style) > 9 ) {
			dd('Stlye can not be more than 9 chars');
		}
		$size = trim(strtoupper($input['size']));
		if (strlen($size) > 5 ) {
			dd('Size can not be more than 5 chars');
		}

		$style_size = $style." ".$size;

		$operation_id = $input['operation_id'];
		$operation = extra_op::findOrFail($operation_id);
		$operation = $operation->operation;
		// dd($operation);

		$key = $style_size."_".$operation_id;

		try {
			
			$db = extra_style_size::findOrFail($input['id']);

			$db->style = $style;
			$db->size = $size;
			$db->style_size = $style_size;
			$old_operation_id = $db->operation_id;
			// dd($old_operation_id);
			$db->operation_id = $operation_id;
			$db->operation = $operation;
			$db->key = $key;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd("Combination of style_size and operation already exist");
		
		}

		// additional check
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' AND b.[size] = '".$size."' "));
			// dd($check_bb);
			
			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."' "));
				// dd($if_exist_extra);
				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						$old_operation_id;
						$operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'style') {

							$db = bbStock_extra::findOrFail($extra->id);
							$status = $db->status;
							$db->delete();

							try {
								$bbStock_extra = new bbStock_extra;
								$bbStock_extra->bbcode = $line->bbcode;
								$bbStock_extra->bbname = $line->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "style_size";
								$bbStock_extra->key = $key."_".$line->bbcode;
								$bbStock_extra->status = $status;
								$bbStock_extra->active = 1;
								$bbStock_extra->save();

							}
							catch (\Illuminate\Database\QueryException $e) {
								$db = bbStock_extra::findOrFail($extra->id);
								$db->active = 1;
								$db->save();			
							}
						}
						if ($existing_operation_type == 'style_size') {

								$db = bbStock_extra::findOrFail($extra->id);
								$db->bbcode = $line->bbcode;
								$db->bbname = $line->bbname;
								$db->operation = $operation;
								$db->operation_id = $operation_id;
								$db->operation_type = "style_size";
								$db->key = $key."_".$line->bbcode;
								// $db->status = "NOT DONE";  // status from previous operation
								$db->active = 1;
								$db->save();
							
						}
						if ($existing_operation_type == 'sku') {
							
						} 
					}
					
				} else {
					// not exist in extra

					try {
						$bbStock_extra = new bbStock_extra;
						$bbStock_extra->bbcode = $line->bbcode;
						$bbStock_extra->bbname = $line->bbname;
						$bbStock_extra->operation = $operation;
						$bbStock_extra->operation_id = $operation_id;
						$bbStock_extra->operation_type = "style_size";
						$bbStock_extra->key = $key."_".$line->bbcode;
						$bbStock_extra->status = "NOT DONE";
						$bbStock_extra->active = 1;
						$bbStock_extra->save();
					}
					catch (\Illuminate\Database\QueryException $e) {
						// return view('extra_style.error');			
					}
				}


			}

		// close 
		
		return Redirect::to('/extra_style_size');
	}

	public function extra_style_size_view($operation_id, $style_size) {

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras WHERE [key] like '".$style_size."_".$operation_id."%' AND operation_type = 'style_size' /*AND active = '1'*/ ORDER BY id asc "));
		// dd($data);
		return view('extra_style_size.view', compact('data'));
	}

	public function extra_style_size_delete($id) {

		$db = extra_style_size::findOrFail($id);
		$db->active = 0;
		$db->save();

		$style = $db->style;
		$old_operation_id = $db->operation_id;

		// additional check 
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' "));
			// dd($check_bb);

			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."' "));
				// dd($if_exist_extra);
				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						$old_operation_id;
						$operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'sku') {

						} 
						if ($existing_operation_type == 'style_size') {

							$bbStock_extra = bbStock_extra::findOrFail($extra->id);
							$bbStock_extra->delete();
						} 
						if ($existing_operation_type == 'style') {

						}
					}
					
				} else {
					
				}

			}
		// close

		return Redirect::to('/extra_style_size');
	}

// STYLE
	public function extra_style() {
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_styles ORDER BY style  asc"));
		return view('extra_style.index', compact('data'));
	}

	public function extra_style_new() {
		//
		$operation_list = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops WHERE active = '1' ORDER BY id asc "));
		return view('extra_style.create', compact('operation_list'));	
	}

	public function extra_style_insert(Request $request) {
		//
		$this->validate($request, ['style'=>'required','operation_id'=>'required']);
		$input = $request->all(); 
		
		$style = trim(strtoupper($input['style']));
		if (strlen($style) > 9 ) {
			dd('Stlye can not be more than 9 chars');
		}
		
		$operation_id = $input['operation_id'];
		$operation = extra_op::findOrFail($operation_id);
		$operation = $operation->operation;
		// dd($operation);
		$old_operation_id = $operation_id;

		$key = $style."_".$operation_id;

		// check if already exist key
		$check = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_styles WHERE [key] = '".$key."' "));
		// dd($check);

		if (isset($check[0]->id)) {
			// dd("Combination of Style and operation already exist");
		}

		try {
			$db = new extra_style;
			$db->style = $style;
			$db->operation_id = $operation_id;
			$db->operation = $operation;
			$db->key = $db->style."_".$db->operation_id;
			$db->save();

		}
		catch (\Illuminate\Database\QueryException $e) {
			// return view('extra_style.error');			
			$db = extra_style::findOrFail($check[0]->id);	
			$db->active = 1;
			$db->save();
		}

		// additional check
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' "));
			// dd($check_bb);
			
			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."'"));

				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'sku') {
							
						} 
						if ($existing_operation_type == 'style_size') {

						} 
						if ($existing_operation_type == 'style') {

							$db = bbStock_extra::findOrFail($extra->id);
							$db->active = 1;
							$db->save();
						}
					}
					
				} else {
					// not exist in extra

					try {
						$bbStock_extra = new bbStock_extra;
						$bbStock_extra->bbcode = $line->bbcode;
						$bbStock_extra->bbname = $line->bbname;
						$bbStock_extra->operation = $operation;
						$bbStock_extra->operation_id = $operation_id;
						$bbStock_extra->operation_type = "style";
						$bbStock_extra->key = $key."_".$line->bbcode;
						$bbStock_extra->status = "NOT DONE";
						$bbStock_extra->active = 1;
						$bbStock_extra->save();

					}
					catch (\Illuminate\Database\QueryException $e) {
						// return view('extra_style.error');			
						
					}
				}
				
			}
			
		// close 
		
		return Redirect::to('extra_style');
	}

	public function extra_style_edit($id) {
		// dd($id);
		$data = extra_style::findOrFail($id);
		$operation_list = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops WHERE active = '1' ORDER BY id asc "));
		
		return view('extra_style.edit', compact('data','operation_list'));
	}

	public function extra_style_update(Request $request) {
		//
		$this->validate($request, ['style'=>'required','operation_id'=>'required']);
		$input = $request->all(); 
		// dd($input);

		$style = trim(strtoupper($input['style']));
		if (strlen($style) > 9 ) {
			dd('Stlye can not be more than 9 chars');
		}
		
		$operation_id = $input['operation_id'];
		$operation = extra_op::findOrFail($operation_id);
		$operation = $operation->operation;
		// dd($operation);

		$key = $style."_".$operation_id;

		try {
			$db = extra_style::findOrFail($input['id']);	
			$db->style = $style;
			$old_operation_id = $db->operation_id;
			// dd($old_operation_id);
			$db->operation_id = $operation_id;
			$db->operation = $operation;
			$db->key = $key;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			// dd("Combination of Style and Operation already exist");
			// return view('extra_style.error');
		}

		// additional check
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' "));
			// dd($check_bb);
			
			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."' "));
				// dd($if_exist_extra);
				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						$old_operation_id;
						$operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'sku') {
							
						} 
						if ($existing_operation_type == 'style_size') {

						} 
						if ($existing_operation_type == 'style') {

							//same op
							try {
								$bbStock_extra = bbStock_extra::findOrFail($extra->id);
								$bbStock_extra->bbcode = $extra->bbcode;
								$bbStock_extra->bbname = $extra->bbname;
								$bbStock_extra->operation = $operation;
								$bbStock_extra->operation_id = $operation_id;
								$bbStock_extra->operation_type = "style";
								$bbStock_extra->key = $key."_".$extra->bbcode;
								$bbStock_extra->status = "NOT DONE";
								$bbStock_extra->active = 1;
								$bbStock_extra->save();

							} catch (\Illuminate\Database\QueryException $e) {
								// return view('extra_style.error');			

								$db = bbStock_extra::findOrFail($extra->id);
								$db->active = 1;
								$db->save();
							}
						}
					}
					
				} else {
					// not exist in extra

					try {
						$bbStock_extra = new bbStock_extra;
						$bbStock_extra->bbcode = $line->bbcode;
						$bbStock_extra->bbname = $line->bbname;
						$bbStock_extra->operation = $operation;
						$bbStock_extra->operation_id = $operation_id;
						$bbStock_extra->operation_type = "style";
						$bbStock_extra->key = $key."_".$line->bbcode;
						$bbStock_extra->status = "NOT DONE";
						$bbStock_extra->active = 1;
						$bbStock_extra->save();
					}
					catch (\Illuminate\Database\QueryException $e) {
						// return view('extra_style.error');			
					}
				
				}
			}

		// close 
		return Redirect::to('/extra_style');
	}

	public function extra_style_view($operation_id, $style) {

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock_extras 
				WHERE [key] like '".$style."_".$operation_id."%' 
						AND operation_type = 'style' 
						/*AND active = '1'*/ 
						ORDER BY id asc "));
		// dd($data);
		return view('extra_style.view', compact('data'));
	}

	public function extra_style_delete($id) {

		$db = extra_style::findOrFail($id);
		$db->active = 0;
		$db->save();

		$style = $db->style;
		$old_operation_id = $db->operation_id;

		// additional check 
			$check_bb = DB::connection('sqlsrv')->select(DB::raw("SELECT 
				b.[bbcode],
				b.[bbname]
				--b.*
			  FROM [bbStock].[dbo].[bbStock] as b
			  WHERE b.[status] = 'STOCK' AND b.[style] = '".$style."' "));
			// dd($check_bb);

			foreach ($check_bb as $line) {

				$if_exist_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras]
					WHERE bbcode = '".$line->bbcode."' AND operation_id = '".$old_operation_id."' "));
				// dd($if_exist_extra);
				// if setup exist in extra
				if (isset($if_exist_extra[0]->id)) {
					// exist in extra
					foreach ($if_exist_extra as $extra) {
						// dd($extra);
						$id = $extra->id;
						$existing_operation_type = $extra->operation_type;
						$existing_operation_id = $extra->operation_id;
						$old_operation_id;
						$operation_id;
						// dd('new operation id: '.$operation_id.'  , existing_operation_id: '.$existing_operation_id);

						if ($existing_operation_type == 'sku') {

						} 
						if ($existing_operation_type == 'style_size') {

						} 
						if ($existing_operation_type == 'style') {

							$bbStock_extra = bbStock_extra::findOrFail($extra->id);
							$bbStock_extra->delete();
						}
					}
					
				} else {
					
				}

			}
		// close

		return Redirect::to('/extra_style');
	}

// OPERATIONS

	public function extra_op() {
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_ops ORDER BY id  asc"));
		return view('extra_op.index', compact('data'));
	}

	public function extra_op_new() {
		//
		return view('extra_op.create');	
	}

	public function extra_op_insert(Request $request) {
		//
		$this->validate($request, ['operation'=>'required']);
		$input = $request->all(); 
		
		$operation = trim(strtoupper($input['operation']));
		
		// check if already exist key
		$check = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_ops WHERE operation = '".$operation."' "));
		// dd($check);

		if (isset($check[0]->id)) {
			dd("Operation already exist");
		}

		try {
			$db = new extra_op;

			$db->operation = $operation;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('extra_op.error');			
		}
		return Redirect::to('extra_op');
	}

	public function extra_op_edit($id) {
		// dd($id);
		$data = extra_op::findOrFail($id);	
		
		$operation = $data->operation;

		return view('extra_op.edit', compact('data', 'operation'));
	}

	public function extra_op_update(Request $request) {
		//
		$this->validate($request, ['operation'=>'required']);

		$input = $request->all(); 
		// dd($input);

		try {
			
			$db = extra_op::findOrFail($input['id']);
			$db->operation = trim(strtoupper($input['operation']));
			$db->save();

			$update_style = DB::connection('sqlsrv')->update(DB::raw("UPDATE extra_styles
			 SET operation = '".$db->operation."' WHERE operation_id = '".$db->id."' "));

			$update_style_size = DB::connection('sqlsrv')->update(DB::raw("UPDATE extra_style_sizes
			 SET operation = '".$db->operation."' WHERE operation_id = '".$db->id."' "));

			$update_style_size = DB::connection('sqlsrv')->update(DB::raw("UPDATE extra_skus
			 SET operation = '".$db->operation."' WHERE operation_id = '".$db->id."' "));

			$update_bbStock_extras = DB::connection('sqlsrv')->update(DB::raw("UPDATE bbStock_extras
			 SET operation = '".$db->operation."' WHERE operation_id = '".$db->id."' "));

		}
		catch (\Illuminate\Database\QueryException $e) {
			dd("Operaton already exist");
			return view('extra_op.error');
		}
		
		return Redirect::to('/extra_op');
	}

	public function extra_op_delete($id) {

		$db = extra_op::findOrFail($id);
		
		try {
			$db->active = 0;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('extra_op.error');			
		}

		return Redirect::to('/extra_op');
	}

}
