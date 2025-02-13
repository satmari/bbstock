<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//use Request;

use App\BBStock_extra;
use App\tempextra1;
use App\tempextra2;
use App\tempextra3;
use DB;

use Session;

class extraController extends Controller {


// BY OP
	public function op_by_op () {

		$ses = Session::getId();
		$delete_ses = DB::connection('sqlsrv')->update(DB::raw("DELETE FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));

		$operations = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT operation FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' "));
		return view('extra.op_by_op', compact('operations'));
	}

	public function op_by_op_1(Request $request) {
		//
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all(); 
		// dd($input);
		$ses = Session::getId();

		if ($input['operation'] == '') {
			
			$operations = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT operation FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' and active = 1"));
			$msge = 'Operation must be selected';
			return view('extra.op_by_op', compact('operations','msge'));
		} else {
			$operation = $input['operation'];
		}

		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' and active = 1 
			and operation = '".$operation."' "));
		
		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
		$msgs = '';
		return view('extra.op_by_op_1', compact('bbs', 'operation', 'bblist', 'ses', 'msgs'));
	}

	public function op_by_op_2(Request $request) {
		//
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all(); 
		// dd($input);
		$ses = Session::getId();

		$operation = $input['operation'];

		if ($input['bbcode1'] != "") {
			$bbcode = $input['bbcode1'];

		} else if ($input['bbcode2'] != "") {
			$bbcode = $input['bbcode2'];

		} else {
			$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' and active = 1 
			and operation = '".$operation."' "));

			$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
			$msge = 'BB must be selected or scanned';
			return view('extra.op_by_op_1', compact('bbs','msge','operation','bblist','ses'));
		}
		
		// error handling	
		$databbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE bbcode = '".$bbcode."'
			 and status = 'NOT DONE' and active = 1 and operation = '".$operation."'"));
				
		if (!isset($databbs[0]->bbname)) {
			
			$bb_main = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock] WHERE bbcode = '".$bbcode."' "));
			if (!isset($bb_main[0]->id)) {
				
				$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
				$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
				$msge = 'This BB is not in BBStock app';
				return view('extra.op_by_op_1', compact('bbs','msge','operation','bblist','ses'));
				
			} else {


				$bb_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE bbcode = '".$bbcode."' "));
				if (!isset($bb_extra[0]->id)) {
					
					$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
					$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
					$msge = 'This BB is in BBStock app but doesent have any operations assigned';
					return view('extra.op_by_op_1', compact('bbs','msge','operation','bblist','ses'));

				} else {

					$bb_extra2 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE bbcode = '".$bbcode."' and active = '1' "));
					
					if (!isset($bb_extra2[0]->id)) {

						$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
						$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
						$msge = 'Can not find any ACTIVE operation for this BB';
						return view('extra.op_by_op_1', compact('bbs','msge','operation','bblist','ses'));	
					
					} else {

						$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
						$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
						$msge = 'Can not find any operation with status NOT DONE for this BB';
						return view('extra.op_by_op_1', compact('bbs','msge','operation','bblist','ses'));	
					}
				}
			}
		}

		try {
			$db = new tempextra1;
			$db->bbcode = $bbcode;
			$db->bbname = $databbs[0]->bbname;
			$db->operation = $operation;
			$db->operation_id = $databbs[0]->operation_id;
			$db->operation_type = $databbs[0]->operation_type;
			$db->ses = $ses;
			$db->key = $bbcode."_".$operation."_".$ses;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
		
		}

		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' and active = 1 
			and operation = '".$operation."' "));
		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
		$msgs = '';
		return view('extra.op_by_op_1', compact('bbs', 'operation', 'bblist', 'ses', 'msgs'));
	}	

	public function remove_empextra1s($id, $session, $operation) {

		// dd($ses);
		$ses = $session;
		DB::connection('sqlsrv')->update(DB::raw("DELETE FROM [bbStock].[dbo].[tempextra1s] WHERE id = '".$id."' and ses = '".$ses."'  "));

		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' and active = 1 
			and operation = '".$operation."' "));

		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
		$msgs = 'Successfuly removed';
		return view('extra.op_by_op_1', compact('bbs','msgs','operation','bblist','ses'));	
	}

	public function op_by_op_confirm (Request $request) {
		//
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all(); 
		// dd($input);
		$ses = $input['ses'];
		$operation = $input['operation'];
		// dd($ses);

		$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));

		foreach ($bb as $value) {
			// dd($value->bbname);

			DB::connection('sqlsrv')->update(DB::raw("UPDATE [bbStock].[dbo].[bbStock_extras] SET status = 'DONE' WHERE 
				bbcode = '".$value->bbcode."' and 
				operation = '".$operation."'  "));

			DB::connection('sqlsrv')->update(DB::raw("DELETE FROM [bbStock].[dbo].[tempextra1s] WHERE 
				bbcode = '".$value->bbcode."' and 
				ses = '".$ses."' and
				operation = '".$operation."'    "));
		}

		
		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' and active = 1 
			and operation = '".$operation."' "));
		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra1s] WHERE ses = '".$ses."' "));
		$msgs = 'Successfuly confirmed';

		return view('extra.op_by_op_1', compact('bbs', 'msgs' ,'operation', 'bblist', 'ses'));
	}

// BY BB
	public function op_by_bb () {

		$ses = Session::getId();
		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
		// dd($bblist);
		return view('extra.op_by_bb', compact('bbs','ses'));
	}

	public function op_by_bb_1(Request $request) {
		//
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all();
		$ses = $input['ses'];
		// dd($input);
		
		if ($input['bbcode'] != "") {
			$bbcode = $input['bbcode'];
			// $bbname = $input['bbname'];

		} else if ($input['bbcode2'] != "") {
			$bbcode = $input['bbcode2'];

		} else {
			$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));

			$msge = 'BB must be selected or scanned';
			return view('extra.op_by_bb', compact('bbs','msge','ses'));
		}
		
		// error handling		
		$operationlist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE 
		 	bbcode = '".$bbcode."' and active = '1'"));
		// dd($operationlist);

		if (!isset($operationlist[0]->bbname)) {

			$bb_main = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock] WHERE bbcode = '".$bbcode."' "));
			if (!isset($bb_main[0]->id)) {
				
				$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
				$msge = 'This BB is not in BBStock app';
				return view('extra.op_by_bb', compact('bbs','msge','ses'));
				
			} else {

				$bb_extra = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE bbcode = '".$bbcode."' "));
				if (!isset($bb_extra[0]->id)) {
					
					$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
					$msge = 'This BB is in BBStock but doesent have any operations assigned';
					return view('extra.op_by_bb', compact('bbs','msge','ses'));

				} else {

					$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] /*WHERE status = 'NOT DONE'*/ "));
					$msge = 'Can not find any ACTIVE operation for this BB';
					return view('extra.op_by_bb', compact('bbs','msge','ses'));	
				}
			}

		} else {
			$bbname = $operationlist[0]->bbname;
			//$oplist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra2s] WHERE ses = '".$ses."' "));
			$msgs = '';
			return view('extra.op_by_bb_1', compact('bbcode','bbname','operationlist','msgs','ses')); 	
		}
	}

	public function op_by_bb_confirm(Request $request) {
		
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all(); 
		// dd($input);

		$ses = $input['ses'];
		$bbcode = $input['bbcode'];
		$bbname = $input['bbname'];
		// dd($ses);

		foreach ($input['hidden'] as $hidden_line) {	
			// var_dump($hidden_line);

			if (!isset($input['extraops'])) {
				// var_dump('missing extra op ');

				$update = DB::connection('sqlsrv')->update(DB::raw("UPDATE [bbStock].[dbo].[bbStock_extras] 
							SET status = 'NOT DONE' 
							WHERE
		 					bbcode = '".$bbcode."' and 
		 					operation = '".$hidden_line."' and
		 					active = '1'"));
			} else {

				if (in_array($hidden_line, $input['extraops'])) {
					// dd('selected');

					$update = DB::connection('sqlsrv')->update(DB::raw("UPDATE [bbStock].[dbo].[bbStock_extras] 
							SET status = 'DONE' 
							WHERE
		 					bbcode = '".$bbcode."' and 
		 					operation = '".$hidden_line."' and
		 					active = '1'"));
				} else {
					// dd('not selected');

					$update = DB::connection('sqlsrv')->update(DB::raw("UPDATE [bbStock].[dbo].[bbStock_extras] 
							SET status = 'NOT DONE' 
							WHERE
		 					bbcode = '".$bbcode."' and 
		 					operation = '".$hidden_line."' and
		 					active = '1'"));
				}
			}
		}

		$operationlist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE 
		 	bbcode = '".$bbcode."' and active = '1'"));
		$msgs = 'Succesfuly saved';

		return view('extra.op_by_bb_1', compact('bbcode','bbname','operationlist','ses','msgs'));
	}

// BY ALL 
	public function all_by_bb () {

		$ses = Session::getId();
		$delete_ses = DB::connection('sqlsrv')->update(DB::raw("DELETE FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
		// $bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
		$bblist;
		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' "));

		// dd($bblist);
		return view('extra.all_by_bb', compact('bbs','bblist','ses'));
	}

	public function all_by_bb_post(Request $request) {
		//
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all();
		// dd($input);
		$ses = $input['ses'];

		if ($input['bbcode1'] != "") {
			$bbcode = $input['bbcode1'];

		} else if ($input['bbcode2'] != "") {
			$bbcode = $input['bbcode2'];

		} else {
			$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' "));

			$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
			$msge = 'BB must be selected or scanned';
			return view('extra.all_by_bb', compact('bbs','msge','bblist','ses'));
		}

		$databbs = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[bbStock_extras] WHERE
			bbcode = '".$bbcode."' "));

		try {
			$db = new tempextra3;
			$db->bbcode = $bbcode;
			$db->bbname = $databbs[0]->bbname;
			$db->operation = "";
			$db->operation_id = "";
			$db->operation_type = "";
			$db->ses = $ses;
			$db->key = $bbcode."_".$ses;
			$db->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
		
		}

		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' "));
		// dd($bblist);
		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
		$msgs = '';
		return view('extra.all_by_bb', compact('bbs','bblist','ses','msgs'));
	}

	public function remove_empextra3s($id, $bbcode, $session) {

		// dd($ses);
		$ses = $session;
		DB::connection('sqlsrv')->update(DB::raw("DELETE FROM [bbStock].[dbo].[tempextra3s] WHERE id = '".$id."' and ses = '".$ses."'  "));

		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' "));
		// dd($bblist);
		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
		$msgs = 'Successfuly removed';
		return view('extra.all_by_bb', compact('bbs','bblist','ses','msgs'));
	}

	public function all_by_bb_confirm(Request $request) {
		
		// $this->validate($request, ['operation' => 'required']);
		$input = $request->all(); 
		// dd($input);
		$ses = $input['ses'];
		// dd($ses);

		$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
		// dd($bb);

		foreach ($bb as $value) {
			// dd($value);

			DB::connection('sqlsrv')->update(DB::raw("UPDATE [bbStock].[dbo].[bbStock_extras] SET status = 'DONE' WHERE 
				bbcode = '".$value->bbcode."' "));

			DB::connection('sqlsrv')->update(DB::raw("DELETE FROM [bbStock].[dbo].[tempextra3s] WHERE 
				bbcode = '".$value->bbcode."' and 
				ses = '".$ses."'  "));
		}

		$bbs = DB::connection('sqlsrv')->select(DB::raw("SELECT DISTINCT bbname, bbcode FROM [bbStock].[dbo].[bbStock_extras] WHERE status = 'NOT DONE' "));
		// dd($bblist);
		$bblist = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM [bbStock].[dbo].[tempextra3s] WHERE ses = '".$ses."' "));
		$msgs = 'Successfuly confirmed';
		return view('extra.all_by_bb', compact('bbs','bblist','ses','msgs'));
	}

}
