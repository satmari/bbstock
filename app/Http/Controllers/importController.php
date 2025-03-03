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
use App\bb_stock_prepare_import;
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

						//var_dump($row['nav_item']." - ".$row['nav_variant']);
						/*
	                	$sql2 = DB::connection('sqlsrv1')->select(DB::raw("
							SET NOCOUNT ON;
							UPDATE [Gordon_LIVE].[dbo].[GORDON\$Item Variant]
								SET [Sap SKU code] = '".$row['correct_sap_sku']."', 
									[SAP Item code] = '".$row['correct_sap_item']."', 
									[SAP Color] = '".$row['correct_sap_color']."'
									,[SAP Size] = '".$row['correct_sap_size']."'
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
						var_dump($row['bbname']." ");
						/*
						$sql2 = DB::connection('sqlsrv')->select(DB::raw("
							SET NOCOUNT ON;
							UPDATE [bbStock].[dbo].[bbStock]
								SET  bbcode = '".$row['bbcode_new']."',
									 bbname = '".$row['bbname_new']."'
									 
							WHERE bbname = '".$row['bbname']."'
							SELECT TOP 1 id FROM [bbStock].[dbo].[bbStock];
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

	public function postImport_bb_su(Request $request) {
	    $getSheetName = Excel::load(Request::file('file'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {


	                	// dd($row);
	                	// dd($row['bb']);
	                	// dd($row['R']);
						
	                	// za stavljanje lokacije_odgovornog u OS
	                	/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
							SET [FA Location Code] = '".$row['r']."'
							WHERE [No_] = '".$row['fa']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
					   */

						/*
						// za dodavanje FA klase OS
	                	// dd($row);
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
							SET [SAP Class code] = '".$row['r']."'
							WHERE [No_] = '".$row['fa']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
					   */

						/*
						// za dodavanje CC u OS
	                	// dd($row);
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
							SET [Global Dimension 1 Code] = '".$row['cc']."'
							WHERE [No_] = '".$row['os']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
						*/
						/*
	                	// za dodavanje CC u OS 2 
	                	// dd($row);
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [Gordon_LIVE].[dbo].[GORDON\$Default Dimension]
							SET [Dimension Value Code] = '".$row['cc']."'
							WHERE [Table ID] = '5600' and [Dimension Code] = 'CC' and [No_] = '".$row['os']."';
							SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Fixed Asset]
					   "));
					   */
	            		
	            		//-----------------------
	            		// dd($row);
	            		// za stavljnje status Complited Subotica
			            // dd($row);
						
						
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [BdkCLZG].[dbo].[CNF_BlueBox] 
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]
					   "));
					   

	                	//Kikinda
						/*
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
					   "));
					   */
					   //-------------------------

						// dd($row['bb']);
	                	// za automatsko skeniranje rolni
						/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		  UPDATE [Gordon_LIVE].[dbo].[GORDON\$WMS Scanned Line]
  							  SET [ScannedYes] = '1' , [ScannedCount] = '1'
  							  WHERE [Document Type] = '1' and [Document No_] = 'HU' and [Barcode No_] = '".$row['bb']."';
							  SELECT TOP 1 [Entry No_] FROM [Gordon_LIVE].[dbo].[GORDON\$WMS Scanned Line]
					   "));
					   */

						// dd($row['item']);
						// dd($row['sapvc']);
	                	// za inport SAP valuation class u Item (Fiorano)
						/*
	                	$sql = DB::connection('sqlsrv3')->select(DB::raw("SET NOCOUNT ON;
	                		  UPDATE [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item]
								SET [SAP VAluation Class] = 'WR04'
								WHERE [No_] = 'FLFIL1';
							  SELECT TOP 1 [No_] FROM [Fiorano_LIVE].[dbo].[Fiorano_live_company\$Item];
					   "));
					   */

						// dd($row['item']);
						// dd($row['sapvc']);
	                	// za inport SAP valuation class u Item (Gordon)
						/*
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		  UPDATE [Gordon_LIVE].[dbo].[GORDON\$Item]
								SET [SAP VAluation Class] = '".$row['sapvc']."'
								WHERE [No_] = '".$row['item']."';
							  SELECT TOP 1 [No_] FROM [Gordon_LIVE].[dbo].[GORDON\$Item];
					   "));
					   */


						/*
						// dd($row['k']);
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [BdkCLZG].[dbo].[CNF_PO]
							SET [POClosed] = '1'
							WHERE [POnum] = '".$row['k']."';
							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]
					   "));
					   */

						
						
						// dd($row['os']);
						// dd($row['location']);
						// dd($row['pos']);
						
		
						/*	Inteos Machines 

						$machine =  DB::connection('sqlsrv1')->select(DB::raw("SELECT mp.*
						      ,mm.*
						      ,mt.*
						  FROM [BdkCLZG].[dbo].[CNF_MachPool] mp
						  LEFT JOIN [BdkCLZG].[dbo].CNF_ModMach as mm ON mp.Cod = mm.MdCod
						  LEFT JOIN [BdkCLZG].[dbo].CNF_MaTypes as mt ON mt.IntKey = mp.MaTyCod
						  where MachNum = '".$row['os']."' "));
						// dd($machine[0]);
						var_dump($machine[0]->MachNum);

						
						//SET Active in Subotica
						 $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_MachPool]
  							SET NotAct = NULL, InRepair = '2020-09-13 07:00:00.000'
  							WHERE Cod = '".$machine[0]->Cod."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
  
  						//SET not active in Kikinda
  						 $sql1 = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
  							UPDATE [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_MachPool]
  							SET NotAct = '1'
  							WHERE Cod = '".$machine[0]->Cod."'	
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
						

  						//CHECK module/location
  						 $sql2 = DB::connection('sqlsrv1')->select(DB::raw("
							SELECT [Module],[ModNam]
							FROM [BdkCLZG].[dbo].[CNF_Modules]
							WHERE [ModNam] = '".$row['location']."' "));
  						 // dd($sql2[0]->Module);
  						 // var_dump($sql2[]->)
						
						
						
						//FIND FIRST NULL POSITION
  						 $sql3 = DB::connection('sqlsrv1')->select(DB::raw("
							SELECT TOP 1 Pos
							FROM [BdkCLZG].[dbo].[CNF_ModMach]
							WHERE Module = '".$sql2[0]->Module."' AND MdCod is NULL
							"));
  						 // dd($sql3[0]->Pos);
  						 // var_dump($sql3[0]->Pos);
  						 

  						 
  						 //UPDATE location and pos //REMOVE OLD
  						  $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_ModMach]
						  	SET MdCod = NULL, [MaStat] = NULL
						  	WHERE Module = '".$machine[0]->Module."' AND Pos = '".$machine[0]->Pos."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));

  						 //UPDATE location and pos //SET NEW
  						  $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_ModMach]
						  	SET MdCod = '".$machine[0]->Cod."', [MaStat] = NULL
						  	WHERE Module = '".$sql2[0]->Module."' AND Pos = '".$sql3[0]->Pos."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
						*/	

						
						/*
						// SET MASHINE TO REPAIR
						//REMOVE location and pos FROR REPAIR machines
  						  $sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
						 	UPDATE [BdkCLZG].[dbo].[CNF_ModMach]
						  	SET MdCod = NULL, [MaStat] = NULL
						  	WHERE MdCod = '".$machine[0]->Cod."'
  							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]"));
						*/

						 // ModMach table 
  						 // [MaStat] = NULL
  						  			// MachPool table == 
  						 			// In Reparir = NOTNULL ([InRepair])
  						 			// Available = NULL ([InRepair])

  						 // [MaStat] = Spare = 0
  						 // [MaStat] = Needed = 1
  						 // [MaStat] = Ready for next chenge = 4
  						 // [MaStat] = On Stock = 5
  						 // [MaStat] = To be repaired = 6

  						 
						
	                }
	            });
	    }
		// return redirect('/');
		dd('Done Subotica');
	}

	public function postImport_bb_ki(Request $request) {
	    $getSheetName = Excel::load(Request::file('file'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            //DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {

	            		//-----------------------
	            		// dd($row);
	            		// za stavljnje status Complited Subotica
			            // dd($row);
						
						/*
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [BdkCLZG].[dbo].[CNF_BlueBox] 
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]
					   "));
					   */

	                	//Kikinda
						
	                	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
					   "));
 						 
						
	                }
	            });
	    }
		// return redirect('/');
		dd('Done Kikinda');
	}

	public function postImport_bb_stock_prepare_import(Request $request) {
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
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file1'))->chunk(5000, function ($reader)
	            
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);

	                foreach($readerarray as $row)
	                {


			            // dd($row);
						$pro = $row['pro'];
						$extra_mat_skeda = $row['extra_mat_skeda'];
						$qty_to_remove_from_stock = (int)$row['qty_to_remove_from_stock'];
						// dd($qty_to_remove_from_stock);

						$table = new bb_stock_prepare_import;

						$table->pro = $pro;
						$table->extra_mat_skeda = $extra_mat_skeda;
						$table->qty_to_remove_from_stock = $qty_to_remove_from_stock;
									
						$table->save();

						/*
	                	$sql = DB::connection('sqlsrv1')->select(DB::raw("SET NOCOUNT ON;
	                		UPDATE [BdkCLZG].[dbo].[CNF_BlueBox] 
							SET [Status] = '99'
							WHERE [BlueBoxNum] = '".$row['bb']."';
							SELECT TOP 1 [BlueBoxNum] FROM [BdkCLZG].[dbo].[CNF_BlueBox]
					   "));
					   */

	                	//Kikinda
						
	      //           	$sql = DB::connection('sqlsrv2')->select(DB::raw("SET NOCOUNT ON;
	      //           		UPDATE [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
							// SET [Status] = '99'
							// WHERE [BlueBoxNum] = '".$row['bb']."';
							// SELECT TOP 1 [BlueBoxNum] FROM [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].[CNF_BlueBox]
					  //  "));
 						 
						
	                }
	            });
	    }
		// return redirect('/');
		dd('Done');
	}
}

