<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use DB;

class statusController extends Controller {

	public function index() {

		//$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock ORDER BY po"));

		return view('status.index');
	}

	// ne koristi se vise
	public function find() {

		$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock ORDER BY po"));

		//dd($bbstock);
		$boxdeleted = 0;
		$boxleft = 0;

		foreach ($bbstock as $box) {
			
			// dd($box);
			$bbcode = $box->bbcode;
			$bbid = $box->id;

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].Status FROM [BdkCLZG].[dbo].[CNF_BlueBox] WHERE [CNF_BlueBox].INTKEY = :somevariable"), array(
				'somevariable' => $bbcode,
			));
			
			if ($inteos) {
			
				//dd($inteos[0]->Status);
				$status = $inteos[0]->Status;
				if ($status == '10' OR $status == '20' OR $status == '99') {

					$results = bbStock::where('id', '=', $bbid)->delete();
					$boxdeleted = $boxdeleted + 1;
				}

				if ($status == '0' OR $status == '30') {
					$boxleft = $boxleft + 1;
				}
			}
		}

		return view('status.result',compact('boxdeleted','boxleft'));
	}

	public function find_by_status(Request $request) {

		//validation
		$this->validate($request, ['password'=>'required']);

		$input = $request->all(); 
		$pass = $input['password'];

		if ($pass == 'marijana') {

			$bbstock = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock ORDER BY po"));

			//dd($bbstock);
			$boxdeleted = 0;
			$boxleft = 0;

			foreach ($bbstock as $box) {
				
				// dd($box);
				$bbcode = $box->bbcode;
				$bbid = $box->id;

				$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].Status FROM [BdkCLZG].[dbo].[CNF_BlueBox] WHERE [CNF_BlueBox].INTKEY = :somevariable"), array(
					'somevariable' => $bbcode,
				));
				
				if ($inteos) {
				
					//dd($inteos[0]->Status);
					$status = $inteos[0]->Status;
					if ($status == '10' OR $status == '20' OR $status == '99') {

						//$results = bbStock::where('id', '=', $bbid)->delete();
						$boxdeleted = $boxdeleted + 1;
					}

					if ($status == '0' OR $status == '30') {
						$boxleft = $boxleft + 1;
					}
				}
			}
		} else {
			$msg = "Marijana, did you really forget your password ?";
			return view('status.error',compact('msg'));			
		}

		return view('status.result',compact('boxdeleted','boxleft'));
	}

}