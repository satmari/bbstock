<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

// use Request;

use App\Po;
use App\User;
use App\bbStock;
// use App\role_user;
use DB;

class importController extends Controller {

		public function index()
	{
		//

		return view('import.index');
	}

	public function postImportUser(Request $request) {
	    $getSheetName = Excel::load(Request::file('file1'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file1'))->chunk(50, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {

						$userbulk = new User;
						$userbulk->name = $row['user'];;
						$userbulk->email = $row['email'];
						$userbulk->password = bcrypt($row['pass']);
						// $userbulk->created_at = date('2019-00-00');
						// $userbulk->updated_at = date('2019-00-00');
												
						$userbulk->save();
	                }
	            });
	    }
		return redirect('/');
	}

	public function postImportRoles(Request $request) {
	    $getSheetName = Excel::load(Request::file('file2'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	//DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file2'))->chunk(50, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {	
	                	
	                	//name	slug	description	level
					
						$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						INSERT INTO [bbStock].[dbo].[roles]
					           ([name]
					           ,[slug]
					           ,[description]
					           ,[level]
					           ,[created_at]
							   ,[updated_at])
					           
					 	VALUES
					          ('".$row['name']."'
					           ,'".$row['slug']."'
					           ,'".$row['description']."'
					           ,'".$row['level']."'
					           ,'2019-01-01'
							   ,'2019-01-01');
							   
						
						 SELECT TOP 1 [id] FROM [bbStock].[dbo].[bbStock];

						"));
	                }
	            });
	    }
		return redirect('/');
	}

	public function postImportUserRoles(Request $request) {
	    $getSheetName = Excel::load(Request::file('file3'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	//DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file3'))->chunk(50, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	/*
	                	role_id	user_id
						*/

						$sql = DB::connection('sqlsrv')->select(DB::raw("SET NOCOUNT ON;
						INSERT INTO [bbStock].[dbo].[role_user]
					           ([role_id]
					           ,[user_id]
					           ,[created_at]
							   ,[updated_at])
					           
					 	VALUES
					          ('".$row['role_id']."'
					           ,'".$row['user_id']."'
					           ,'2019-01-01'
							   ,'2019-01-01');
							   
						
						 SELECT TOP 1 [id] FROM [bbStock].[dbo].[bbStock];

						"));
	                }
	            });
	    }
		return redirect('/');
	}


	public function postImportUpdatePass(Request $request) {
	    $getSheetName = Excel::load(Request::file('file4'))->getSheetNames();
	    
	    
	    $sql = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM users"));

	    for ($i=0; $i < count($sql) ; $i++) { 
	    	
	    	// dd($sql[$i]->password);

	    	$password = bcrypt($sql[$i]->name);
	    	// dd($password);

			$sql2 = DB::connection('sqlsrv')->select(DB::raw("
					SET NOCOUNT ON;
					UPDATE [bbStock].[dbo].[users]
					SET password = '".$password."'
					WHERE name = '".$sql[$i]->name."';
					SELECT TOP 1 [id] FROM [bbStock].[dbo].[users];
				"));	    	

	    }

		return redirect('/');
	}

	public function update_pitch()
	{
		
		$sql = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock"));

		for ($i=0; $i < count($sql) ; $i++) { 
			
			// dd($sql[$i]->bbcode);

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant,[CNF_BlueBox].CREATEDATE,[CNF_PO].POnum,[CNF_PO].SMVloc as smv,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [CNF_BlueBox] FULL outer join [CNF_PO] on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
				'somevariable' => $sql[$i]->bbcode,
			));	

			// dd($inteos);

			$bb = bbStock::findOrFail($sql[$i]->id);
		
			$bb->pitch_time = round($inteos[0]->smv / 20 * $bb->qty, 3);
			$bb->save();


		}

		
	}

}
