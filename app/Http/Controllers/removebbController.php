<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use DB;

class removebbController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('removebb.index');
	}

	public function destroy(Request $request)
	{
		//remove BB
		//validation
		$this->validate($request, ['bb_to_remove'=>'required|max:10']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);
	
		$bb_to_remove = $input['bb_to_remove'];
		$results = bbStock::where('bbcode', '=', $bb_to_remove)->delete();
	
		if ($results == false) {
		 	return view('removebb.error'); //1971107960
		} else {
			return view('removebb.success');		
		}
	
	}
	

}
