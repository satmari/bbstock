<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

// use Illuminate\Http\Request;
use Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Po;
use App\User;
use App\bbStock;
// use App\role_user;
use DB;

class importController extends Controller {

		public function index() {
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
	    	/*
			$sql2 = DB::connection('sqlsrv')->select(DB::raw("
					SET NOCOUNT ON;
					UPDATE [bbStock].[dbo].[users]
					SET password = '".$password."'
					WHERE name = '".$sql[$i]->name."';
					SELECT TOP 1 [id] FROM [bbStock].[dbo].[users];
				"));	    	
			*/
	    }

		return redirect('/');
	}

	public function update_pitch() {
		
		$sql = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock"));

		for ($i=0; $i < count($sql) ; $i++) { 
			
			// dd($sql[$i]->bbcode);
			/*
			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT	bb.INTKEY,
					bb.IntKeyPO,
					bb.BlueBoxNum,
					bb.BoxQuant,
					bb.CREATEDATE,
					po.POnum,
					po.SMVloc as smv,
					sku.Variant,
					sku.ClrDesc,
					s.StyCod
			FROM [BdkCLZG].[dbo].[CNF_BlueBox] as bb
			FULL outer join [BdkCLZG].[dbo].[CNF_PO] as po on po.INTKEY = bb.IntKeyPO
			FULL outer join [BdkCLZG].[dbo].[CNF_SKU] as sku on sku.INTKEY = po.SKUKEY 
			FULL outer join [BdkCLZG].[dbo].[CNF_STYLE] as s on s.INTKEY = sku.STYKEY 
			WHERE bb.INTKEY = '".$sql[$i]->bbcode."'
			UNION ALL
			SELECT	bb.INTKEY,
					bb.IntKeyPO,
					bb.BlueBoxNum,
					bb.BoxQuant,
					bb.CREATEDATE,
					po.POnum,
					po.SMVloc as smv,
					sku.Variant,
					sku.ClrDesc,
					s.StyCod
			FROM [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox] as bb
			FULL outer join [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_PO] as po on po.INTKEY = bb.IntKeyPO
			FULL outer join [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_SKU] as sku on sku.INTKEY = po.SKUKEY 
			FULL outer join [SBT-SQLDB01P\\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_STYLE] as s on s.INTKEY = sku.STYKEY 
			WHERE bb.INTKEY = '".$sql[$i]->bbcode."' "));	
			*/
			// dd($inteos);

			if (isset($inteos[0])) {

				$bb = bbStock::findOrFail($sql[$i]->id);
		
				$bb->pitch_time = round($inteos[0]->smv / 20 * $bb->qty, 3);
				$bb->save();
				
			} else {
				// dd("Greska: ".$sql[$i]->bbcode);
			}

			
		}
	}

	public function postImportSAP(Request $request) {
	    $getSheetName = Excel::load(Request::file('file5'))->getSheetNames();
	    
	    
	    //$sql = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM users"));
	    /*
	    for ($i=0; $i < count($sql) ; $i++) { 
	    	
	    	// dd($sql[$i]->password);

	    	$sql2 = DB::connection('sqlsrv')->select(DB::raw("
					SET NOCOUNT ON;
					UPDATE [bbStock].[dbo].[users]
					SET password = '".$password."'
					WHERE name = '".$sql[$i]->name."';
					SELECT TOP 1 [id] FROM [bbStock].[dbo].[users];
				"));	    	

	    }
	    */

	    // dd("Cao");

	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	//DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file5'))->chunk(50, function ($reader)
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	
						// dd($row['nav_item']);
						// dd($row['nav_variant']);
						// dd($row['correct_sap_sku']);
						// dd($row['correct_sap_item']);
						// dd($row['correct_sap_color']);
						// dd($row['correct_sap_size']);

						var_dump($row['nav_item']." - ".$row['nav_variant']);
						/*
	                	$sql2 = DB::connection('sqlsrv1')->select(DB::raw("
							SET NOCOUNT ON;
							UPDATE [Gordon_LIVE].[dbo].[GORDON\$Item Variant]
								SET [Sap SKU code] = '".$row['correct_sap_sku']."', 
									[SAP Item code] = '".$row['correct_sap_item']."', 
									[SAP Color] = '".$row['correct_sap_color']."', 
									[SAP Size] = '".$row['correct_sap_size']."'
							WHERE [Item No_] = '".$row['nav_item']."' AND [Code] = '".$row['nav_variant']."'
							SELECT TOP 1 [Item No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Item Variant];
						"));	
						*/

						/*
						$sql2 = DB::connection('sqlsrv6')->select(DB::raw("
							SET NOCOUNT ON;
							UPDATE [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item Variant]
								SET [Sap SKU code] = '".$row['correct_sap_sku']."', 
									[SAP Item code] = '".$row['correct_sap_item']."', 
									[SAP Color] = '".$row['correct_sap_color']."', 
									[SAP Size] = '".$row['correct_sap_size']."'
							WHERE [Item No_] = '".$row['nav_item']."' AND [Code] = '".$row['nav_variant']."'
							SELECT TOP 1 [Item No_] FROM [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item Variant];
						"));
						*/
						/*
						$sql2 = DB::connection('sqlsrv6')->select(DB::raw("
							SET NOCOUNT ON;
							UPDATE [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item Variant]
								SET [Sap SKU code] = '".$row['sap_code']."'
							WHERE [Item No_] = '".$row['nav_item']."' AND [Code] = '".$row['nav_variant']."'
							SELECT TOP 1 [Item No_] FROM [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item Variant];
						"));
						*/
						
	                }
	            });
	    }


	    dd("Done");
		// return redirect('/');
	}

	public function postImportSAPval(Request $request) {
	    $getSheetName = Excel::load(Request::file('file6'))->getSheetNames();
	    
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	//DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file6'))->chunk(50, function ($reader)
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {
	                	
						// dd($row['nav_item']);
						// dd($row['nav_val']);

						var_dump($row['nav_item']." - ".$row['nav_val']);
						/*
	                	$sql2 = DB::connection('sqlsrv1')->select(DB::raw("
	                		SET NOCOUNT ON;
							UPDATE [Gordon_LIVE].[dbo].[GORDON\$Item]
							SET [SAP Valuation Class] = '".$row['nav_val']."', [Sap code no var] = '".$row['sap_code']."'
							WHERE [No_] = '".$row['nav_item']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Item];
						"));	
						*/

	            		/*
	            		$sql2 = DB::connection('sqlsrv6')->select(DB::raw("
	                		SET NOCOUNT ON;
							UPDATE [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item]
 							SET [SAP VAluation Class] = '".$row['nav_val']."', [Sap code no var] = '".$row['sap_code']."'
							WHERE [No_] = '".$row['nav_item']."';
							SELECT TOP 1 [No_] FROM [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item];
						"));	
						*/
						/*
						$sql2 = DB::connection('sqlsrv6')->select(DB::raw("
	                		SET NOCOUNT ON;
							UPDATE [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item]
 							SET [SAP VAluation Class] = '".$row['nav_val']."'
							WHERE [No_] = '".$row['nav_item']."';
							SELECT TOP 1 [No_] FROM [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item];
						"));
						*/
	                }
	            });
	    }


	    dd("Done");
		// return redirect('/');
	}

}

