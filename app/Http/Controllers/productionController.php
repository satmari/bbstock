<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\bb_stock_log;
use App\locations;

use DB;
use Log;

use Session;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Auth;

class productionController extends Controller {

	public function index()
	{
		//
		/*
		$username = Session::get('username');

		if (!isset($username)) {

			$user = User::find(Auth::id());
			$username = $user->name;
			Session::set('username', $username);	
		}
		*/

		$user = User::find(Auth::id());

		if (!isset($user->name)) {
			$username = strtoupper(Session::get('username'));

		} else {

			$username = strtoupper($user->name);
			Session::set('username', $username);	
			// dd($user->name);
		}

	    // if user has at least one role
	    $msg = "Hi module: ".$username;
	    // var_dump($msg);
	    try {
	    	$db = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE location = '".$username."' AND (status != 'TRANSIT' AND status != 'MOVING') ORDER BY CASE WHEN status = 'DELIVERED' THEN '1'
				WHEN status = 'WIP' THEN '2'
				WHEN status = 'FINISHING' THEN '3'
				ELSE status END ASC, updated_at asc "));

	    	$status_sum = DB::connection('sqlsrv')->select(DB::raw("SELECT status,SUM(qty) as sum_qty, SUM(pitch_time) as sum_pitch_time FROM bbStock WHERE location = '".$username."' and status != 'COMPLETED' and status != 'TRANSIT'  GROUP BY status"));

	    	return view('production.index', compact('username','db','status_sum'));
	    }
	    catch (\Illuminate\Database\QueryException $e) {
			return redirect('/production');
	    }
		
		return redirect('/');
	}

	public function deliver($username) 
	{
		// dd($username);
		$count = DB::connection('sqlsrv')->select(DB::raw("SELECT COUNT(id) as c FROM bbStock WHERE location =  '".$username."' AND status = 'TRANSIT' "));
		// dd($count[0]->c);

		if (isset($count[0]->c)) {
			$count = $count[0]->c;
		} else {
			$count = 0;
		}
		return view('production.deliver_confirm', compact('username','count'));
	}

	public function deliver_confirm($username) 
	{
		try {

		$da = date("Y-m-d H:i:s");
		// dd($da);
		$username = strtoupper($username);
		
		$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
				INSERT INTO [bbStock].[dbo].[deliveredlogs]
			           ([bbcode]
			           ,[bbname]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[boxdate]
			           ,[numofbb]
			           ,[location]
			           ,[status]
			           ,[bagno]
			           ,[created_at]
					   ,[updated_at])
			 SELECT 
					   [bbcode]
			           ,[bbname]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[boxdate]
			           ,[numofbb]
			           ,[location]
			           ,'DELIVERED'
			           ,[bagno]
			           ,[created_at]
					   ,'".$da."'

			 FROM [bbStock].[dbo].[bbStock]
			 WHERE status = 'TRANSIT' and location = '".$username."' ;
			 SELECT TOP 1 [bbcode] FROM [bbStock].[dbo].[bbStock];
			"));

		
		$sql1 = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
			SET status = 'DELIVERED', updated_at = '".$da."'
			OUTPUT INSERTED.id
			WHERE status = 'TRANSIT' and location = '".$username."'  "));
		}
		catch (\Illuminate\Database\QueryException $e) {
		
			// dd($username);
			$count = DB::connection('sqlsrv')->select(DB::raw("SELECT COUNT(id) as c FROM bbStock WHERE location =  '".$username."' AND status = 'TRANSIT' "));
			// dd($count[0]->c);

			if (isset($count[0]->c)) {
				$count = $count[0]->c;
			} else {
				$count = 0;
			}
			return view('production.deliver_confirm', compact('username','count'));

		}


		return redirect('/production');
	}

	public function give($id)
	{
		// dd($bb);

		$locations = locations::orderBy('id')->where('location_type','=','MODULE/LINE')->lists('location','location');
		return view('production.give_confirm', compact('id', 'locations'));

	}

	public function give_confirm(Request $request)
	{
		$this->validate($request, ['location_new'=>'required']);

		$location_input = $request->all(); // change use (delete or comment user Requestl; )
		
		$location = $location_input['location_new'];
		// dd($location);
		$id = $location_input['id'];
		// dd($bb);

		$bb = bbStock::findOrFail($id);
		
		$bb->location = $location;
		$bb->status = "MOVING";
		$bb->save();
		
		return Redirect::to('/production');
	}

	public function receive($username)
	{
		// dd($username);
		$count = DB::connection('sqlsrv')->select(DB::raw("SELECT COUNT(id) as c FROM bbStock WHERE location = '".$username."' AND status = 'MOVING' "));
		// dd($count[0]->c);

		if (isset($count[0]->c)) {
			$count = $count[0]->c;
		} else {
			$count = 0;
		}
		return view('production.receive_confirm', compact('username','count'));
	}

	public function receive_confirm($username) 
	{
		
		try {

		$da = date("Y-m-d H:i:s");
		// dd($da);
		
		$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
			SET status = 'DELIVERED', updated_at = '".$da."'
			OUTPUT INSERTED.id
			WHERE status = 'MOVING' and location = '".$username."'  "));
		}
		catch (\Illuminate\Database\QueryException $e) {

			// dd($username);
			$count = DB::connection('sqlsrv')->select(DB::raw("SELECT COUNT(id) as c FROM bbStock WHERE location = '".$username."' AND status = 'MOVING' "));
			// dd($count[0]->c);

			if (isset($count[0]->c)) {
				$count = $count[0]->c;
			} else {
				$count = 0;
			}
			return view('production.receive_confirm', compact('username','count'));
		}

		return redirect('/production');
	}

	public function bundle($id) 
	{

		$bbname = DB::connection('sqlsrv')->select(DB::raw("SELECT bbname FROM bbStock WHERE id = '".$id."' "));
		// dd($bbname[0]->bbname);
		// $bb = substr($bbname[0]->bbname,-9);
		$bb = $bbname[0]->bbname;

		return view('production.bundle_confirm', compact('id','bb'));
	}

	public function bundle_confirm($id) 
	{
		try {

		$da = date("Y-m-d H:i:s");
		// dd($da);

		$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
			SET status = 'WIP', updated_at = '".$da."'
			OUTPUT INSERTED.id
			WHERE id  = '".$id."' "));

		$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
				INSERT INTO [bbStock].[dbo].[bundlelogs]
			           ([bbcode]
			           ,[bbname]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[boxdate]
			           ,[numofbb]
			           ,[location]
			           ,[status]
			           ,[bagno]
			           ,[created_at]
					   ,[updated_at])
			           
			 SELECT 
					   [bbcode]
			           ,[bbname]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[boxdate]
			           ,[numofbb]
			           ,[location]
			           ,[status]
			           ,[bagno]
			           ,[created_at]
					   ,'".$da."'

			 FROM [bbStock].[dbo].[bbStock]
			 WHERE [id] = '".$id."';
			 SELECT TOP 1 [bbcode] FROM [bbStock].[dbo].[bbStock];
			"));

		}
		catch (\Illuminate\Database\QueryException $e) {
			$da = date("Y-m-d H:i:s");
			// dd($da);

			$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
			SET status = 'WIP', updated_at = '".$da."'
			OUTPUT INSERTED.id
			WHERE id  = '".$id."' "));

			$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
				INSERT INTO [bbStock].[dbo].[bundlelogs]
			           ([bbcode]
			           ,[bbname]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[boxdate]
			           ,[numofbb]
			           ,[location]
			           ,[status]
			           ,[bagno]
			           ,[created_at]
					   ,[updated_at])
			 SELECT 
					   [bbcode]
			           ,[bbname]
			           ,[po]
			           ,[style]
			           ,[color]
			           ,[size]
			           ,[qty]
			           ,[boxdate]
			           ,[numofbb]
			           ,[location]
			           ,[status]
			           ,[bagno]
			           ,[created_at]
					   ,'".$da."'

			 FROM [bbStock].[dbo].[bbStock]
			 WHERE [id] = '".$id."';
			 SELECT TOP 1 [bbcode] FROM [bbStock].[dbo].[bbStock];
			"));
		}

		return redirect('/production');
	}

	public function to_finish()
	{
		//

		$db = DB::connection('sqlsrv')->select(DB::raw("SELECT bbcode,status FROM bbStock WHERE status != 'FINISHING' and status != 'COMPLETED' ORDER BY id DESC"));
		// dd($db);

		for ($i=0; $i < count($db); $i++) { 
			
			// dd($db[$i]->bbcode);
			// $inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].Status FROM [CNF_BlueBox] WHERE [CNF_BlueBox].INTKEY = :somevariable"), array(
			// 	'somevariable' => $db[$i]->bbcode,
			// ));	

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT	bb.Status FROM [BdkCLZG].[dbo].[CNF_BlueBox] as bb WHERE bb.[INTKEY] = '".$db[$i]->bbcode."'
			UNION ALL
			SELECT	bb.Status FROM [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox] as bb WHERE bb.INTKEY = '".$db[$i]->bbcode."' "));

			if (isset($inteos)) {
				// dd($inteos[0]->Status);
				// 0	New
				// 10	On Module
				// 20	In Use
				// 30	Suspended
				// 99	Completed

				if (($inteos[0]->Status == '10') OR ($inteos[0]->Status == '20')) {
					
					$da = date("Y-m-d H:i:s");
					// dd($da);

					// dd("Status u Inteosu ".$inteos[0]->Status." , status u app: ".$db[$i]->status);
					$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
					SET status = 'FINISHING', updated_at = '".$da."'
					OUTPUT INSERTED.id
					WHERE bbcode  = '".$db[$i]->bbcode."' "));
				}
			}
		}
		return redirect('/');
	}

	public function to_complete()
	{

		$db = DB::connection('sqlsrv')->select(DB::raw("SELECT bbcode,status FROM bbStock WHERE status != 'COMPLETED' ORDER BY id DESC"));
		// dd($db);

		for ($i=0; $i < count($db); $i++) { 
			
			// dd($db[$i]->bbcode);
			// $inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].Status FROM [CNF_BlueBox] WHERE [CNF_BlueBox].INTKEY = :somevariable"), array(
			// 	'somevariable' => $db[$i]->bbcode,
			// ));	

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT	bb.Status FROM [BdkCLZG].[dbo].[CNF_BlueBox] as bb WHERE bb.INTKEY = '".$db[$i]->bbcode."'
			UNION ALL
			SELECT	bb.Status FROM [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox] as bb WHERE bb.[INTKEY] = '".$db[$i]->bbcode."' "));

			if (isset($inteos)) {
				// dd($inteos[0]->Status);
				// 0	New
				// 10	On Module
				// 20	In Use
				// 30	Suspended
				// 99	Completed

				if ($inteos[0]->Status == '99') {
					
					// dd("Status u Inteosu ".$inteos[0]->Status." , status u app: ".$db[$i]->status);
					/*
					$sql = DB::connection('sqlsrv')->select(DB::raw("UPDATE bbStock
					SET status = 'COMPLETED'
					OUTPUT INSERTED.id
					WHERE bbcode  = '".$db[$i]->bbcode."' "));
					*/

					$da = date("Y-m-d H:i:s");
					// dd($da);

					$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						INSERT INTO [bbStock].[dbo].[bb_stock_logs]
					           ([bbcode]
					           ,[bbname]
					           ,[po]
					           ,[style]
					           ,[color]
					           ,[size]
					           ,[qty]
					           ,[boxdate]
					           ,[numofbb]
					           ,[location]
					           ,[status]
					           ,[bagno]
					           ,[created_at]
							   ,[updated_at])
					           
					 SELECT 
								[bbcode]
					           ,[bbname]
					           ,[po]
					           ,[style]
					           ,[color]
					           ,[size]
					           ,[qty]
					           ,[boxdate]
					           ,[numofbb]
					           ,[location]
					           ,'COMPLETED'
					           ,[bagno]
					           ,[created_at]
							   ,'".$da."'
							   
					 FROM [bbStock].[dbo].[bbStock]
					 WHERE [bbcode] = '".$db[$i]->bbcode."';
					 SELECT TOP 1 [bbcode] FROM [bbStock].[dbo].[bbStock];

					"));

					
					$sql1 = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
					DELETE FROM [bbStock].[dbo].[bbStock] WHERE [bbcode] = '".$db[$i]->bbcode."';
					SELECT TOP 1 [bbcode] FROM [bbStock].[dbo].[bbStock]; "));

				}
			}
		}
		return redirect('/');
		
	}
}