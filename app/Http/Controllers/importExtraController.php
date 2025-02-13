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

use App\extra_style;
use App\extra_style_size;
use App\extra_sku;
use App\extra_op;

use DB;

class importExtraController extends Controller {

	public function indexextra() {
		//
		return view('import.indexextra');
	}

	public function postImportExtraStyle(Request $request) {
	    $getSheetName = Excel::load(Request::file('file1'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            // DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file1'))->chunk(5000, function ($reader)
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);
	                var_dump('Import info: <br/>');

	                foreach($readerarray as $row)
	                {

	                	// dd($row);
	                	$operation = 	trim(strtoupper($row['operation']));
	                	$style = 		trim(strtoupper($row['style']));
	                	
	                	$check_op = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_ops WHERE operation = '".$operation."' "));
	                	// dd($check_op);

	                	if (isset($check_op[0]->id)) {
	                		$operation_id = $check_op[0]->id;
	                		$key = $style."_".$operation_id;
	                		
	                		$check_key = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_styles WHERE [key] = '".$key."' "));

	                		if (!isset($check_key[0]->id)) {

	                			$db = new extra_style;
								$db->style = $style;
								$db->operation_id = $operation_id;
								$db->operation = $operation;
								$db->key = $key;
								$db->save();

								var_dump('OK: Style '.$style.' and operation '.$operation.' -> IMPORTED SUCCESSFULY <br/>');

	                		} else {

	                			var_dump('ERROR: Style '.$style.' and operation '.$operation.' alredy exist <br/>');
	                		}

	                	} else {
	                		var_dump('ERROR: Operation '.$operation.' does not exist in operation list. Please add operation in operation list <br/>');

	                	}

	                }
	            });
	    }
		// return redirect('/');
	}

	public function postImportExtraStyleSize(Request $request) {
	    $getSheetName = Excel::load(Request::file('file2'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            // DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file2'))->chunk(5000, function ($reader)
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);
	                var_dump('Import info: <br/>');

	                foreach($readerarray as $row)
	                {
	                	// dd($row);
	                	$operation = 	trim(strtoupper($row['operation']));
	                	$style = 		trim(strtoupper($row['style']));
	                	$size = 		trim(strtoupper($row['size']));

	                	$check_op = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_ops WHERE operation = '".$operation."' "));
	                	// dd($check_op);

	                	if (isset($check_op[0]->id)) {
	                		$operation_id = $check_op[0]->id;
	                		$style_size = $style." ".$size;
	                		$key = $style_size."_".$operation_id;
	                		
	                		$check_key = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_style_sizes WHERE [key] = '".$key."' "));

	                		if (!isset($check_key[0]->id)) {

	                			$db = new extra_style_size;
								$db->style = $style;
								$db->size = $size;
								$db->style_size = $style_size;
								$db->operation_id = $operation_id;
								$db->operation = $operation;
								$db->key = $key;
								$db->save();

								var_dump('OK: Style '.$style.', size '.$size.' and operation '.$operation.' -> IMPORTED SUCCESSFULY <br/>');

	                		} else {

	                			var_dump('ERROR: Style '.$style.', size '.$size.' and operation '.$operation.' alredy exist <br/>');
	                		}

	                	} else {
	                		var_dump('ERROR: Operation '.$operation.' does not exist in operation list. Please add operation in operation list <br/>');

	                	}

	                }
	            });
	    }
		// return redirect('/');
	}

	public function postImportExtraSKU(Request $request) {
	    $getSheetName = Excel::load(Request::file('file3'))->getSheetNames();
	    
	    foreach($getSheetName as $sheetName)
	    {
	        //if ($sheetName === 'Product-General-Table')  {
	    	//selectSheetsByIndex(0)
	           	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	            // DB::table('users')->truncate();
	
	            //Excel::selectSheets($sheetName)->load($request->file('file'), function ($reader)
	            //Excel::selectSheets($sheetName)->load(Input::file('file'), function ($reader)
	            //Excel::filter('chunk')->selectSheetsByIndex(0)->load(Request::file('file'))->chunk(50, function ($reader)
	            Excel::filter('chunk')->selectSheets($sheetName)->load(Request::file('file3'))->chunk(5000, function ($reader)
	            {
	                $readerarray = $reader->toArray();
	                //var_dump($readerarray);
	                var_dump('Import info: <br/>');

	                foreach($readerarray as $row)
	                {

	                	// dd($row);
	                	$operation = 	trim(strtoupper($row['operation']));
	                	$style = 		trim(strtoupper($row['style']));
	                	$color = 		trim(strtoupper($row['color']));
	                	$size = 		trim(strtoupper($row['size']));

	                	$sku = trim(str_pad($style,9,' ').str_pad($color,4,' ').str_pad($size,5,' '));

	                	
	                	$check_op = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM extra_ops WHERE operation = '".$operation."' "));
	                	// dd($check_op);

	                	if (isset($check_op[0]->id)) {
	                		$operation_id = $check_op[0]->id;
	                		$key = $sku."_".$operation_id;
	                		
	                		$check_key = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM extra_skus WHERE [key] = '".$key."' "));

	                		if (!isset($check_key[0]->id)) {

	                			$db = new extra_sku;
								$db->style = $style;
								$db->color = $color;
								$db->size = $size;
								$db->sku = $sku;
								$db->operation_id = $operation_id;
								$db->operation = $operation;
								$db->key = $key;
								$db->save();

								var_dump('OK: Style '.$style.', color '.$color.', size '.$size.' and operation '.$operation.' -> IMPORTED SUCCESSFULY <br/>');

	                		} else {

	                			var_dump('ERROR: Style '.$style.', color '.$color.', size '.$size.' and operation '.$operation.' alredy exist <br/>');
	                		}

	                	} else {
	                		var_dump('ERROR: Operation '.$operation.' does not exist in operation list. Please add operation in operation list <br/>');

	                	}

	                }
	            });
	    }
		// return redirect('/');
	}
	
}
