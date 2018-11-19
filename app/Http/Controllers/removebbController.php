<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\bb_stock_log;

use DB;
use Log;

use Session;

class removebbController extends Controller {


	public function index()
	{

		$ses = Session::get('bb_to_remove');
		//ses = $request->session()->get('bb_to_remove');
		return view('removebb.index',compact('ses'));
	}

	public function destroy(Request $request)
	{
		//remove BB
		//validation
		//$this->validate($request, ['bb_to_remove'=>'required|max:10']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);
	
		$bbcode = $input['bb_to_remove'];
		//$results = bbStock::where('bbcode', '=', $bb_to_remove)->delete();
		//dd($bbcode);

		if ($bbcode) {

			$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT id,bbname,numofbb FROM bbStock WHERE bbcode = ".$bbcode));

			if (empty($bb)) {
				$msg = 'BB not exist in BB stock';
			    //return view('removebb.index',compact('msg','bb_to_remove_array_unique','sumofbb'));
			
			} else {

				$bbid = $bb[0]->id;
				$bbcode;
				$bbname = $bb[0]->bbname;
				$numofbb = $bb[0]->numofbb;

				$bbarray = array(
				'id' => $bbid,
				'bbcode' => $bbcode,
				'bbname' => $bbname,
				'numofbb' => $numofbb
				);

				Session::push('bb_to_remove_array',$bbarray);
				//dd($bbarray);
			}
		}

		$bb_to_remove_array = Session::get('bb_to_remove_array');
		//dd($bb_to_remove_array);

		if ($bb_to_remove_array != null) {

			$bb_to_remove_array_unique = array_map("unserialize", array_unique(array_map("serialize", $bb_to_remove_array)));
			//dd($bb_to_remove_array_unique);

			$sumofbb =0;
			foreach ($bb_to_remove_array_unique as $line) {
				foreach ($line as $key => $value) {
					if ($key == 'numofbb') {
						$sumofbb+=$value;
					}
				}
			}
		}

		return view('removebb.index',compact('bb_to_remove_array_unique','sumofbb','msg'));	
	}

	public function destroybb(Request $request)
	{

		// $input = $request->all(); // change use (delete or comment user Requestl; )
		// var_dump($input);
	
		// $bbcode = $input['bb_to_remove_array_unique'];

		// dd($bbcode);

		$bb_to_remove_array = Session::get('bb_to_remove_array');
		//dd($bb_to_remove_array);
		
		//$bb_to_remove_array_unique = array_map("unserialize", array_unique(array_map("serialize", $bb_to_remove_array)));

		//dd($bb_to_remove_array_unique);
		if (isset($bb_to_remove_array)) {
			foreach ($bb_to_remove_array as $line) {
				foreach ($line as $key => $value) {
					if ($key == 'bbcode') {
						//dd($value);

						
						$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE bbcode = '".$value."' "));

						// dd($bb[0]->bbcode);

						if (isset($bb[0]->bbcode)) {
							
							$bbStock_log = new bb_stock_log;

							$bbStock_log->bbcode = $bb[0]->bbcode;
							$bbStock_log->bbname = $bb[0]->bbname;
							$bbStock_log->po = $bb[0]->po;
							$bbStock_log->style = $bb[0]->style;
							$bbStock_log->color = $bb[0]->color;
							$bbStock_log->size = $bb[0]->size;
							$bbStock_log->qty = $bb[0]->qty;
							$bbStock_log->boxdate = $bb[0]->boxdate;
							$bbStock_log->numofbb = $bb[0]->numofbb;
							$bbStock_log->location = $bb[0]->location;

							$bbStock_log->save();

						}
												
						$results = bbStock::where('bbcode', '=', $value)->delete();
					}
				}
			}
			Session::set('bb_to_remove_array', null);
			$msg = "All scanned BB succesfuly removed form Stock";
			return view('removebb.success',compact('msg'));
		}

		Session::set('bb_to_remove_array', null);
		$msg = "List of BB to delete is empty";
		return view('removebb.success',compact('msg'));
		
	}

}