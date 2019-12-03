<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\target;

use DB;
use Log;

use Session;

class targetController extends Controller {

	public function index($username)
	{
		//

		// dd($username);
		$line = $username;

		$rel_po = DB::connection('sqlsrv1')->select(DB::raw("SELECT RIGHT([No_],6) as po FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] WHERE [Status] = '3'"));

		// dd($data);

		return view('target.index', compact('line','rel_po'));
	}

	public function target_confirm(Request $request)
	{
		//validation
		$this->validate($request, ['komesa'=>'required', 'req_type'=>'required']);

		$input = $request->all(); 
		// dd($input);
		$komesa = $input['komesa'];
		$req_type = $input['req_type'];
		$line = $input['line'];

		$po_data = DB::connection('sqlsrv2')->select(DB::raw("SELECT TOP 1 po.POnum, st.StyCod, sku.Variant
		FROM dbo.CNF_PO as po
		LEFT OUTER JOIN  dbo.CNF_SKU AS sku ON po.SKUKEY = sku.INTKEY 
		LEFT OUTER JOIN  dbo.CNF_STYLE AS st ON sku.STYKEY = st.INTKEY
		WHERE po.POnum  like  '%".$komesa."' "));

		// dd($po_data[0]->Variant);

		$style = $po_data[0]->StyCod;		
		// dd($style);

		if (isset($po_data[0]->Variant)) {

		$brlinija = substr_count($po_data[0]->Variant,"-");
				// echo $brlinija." ";

				if ($brlinija == 2)
				{
					list($ColorCode, $size1, $size2) = explode('-', $po_data[0]->Variant);
					$Size = $size1."-".$size2;
					// echo $color." ".$size;	
				} else {
					list($ColorCode, $Size) = explode('-', $po_data[0]->Variant);
					// echo $color." ".$size;
				}

				$color = $ColorCode;
				// $size = $Size;
		}
		// dd($color);
		// $msg = '';
		return view('target.enter_target', compact('line','komesa', 'style', 'color', 'req_type', 'msg'));
	}

	public function target_enter(Request $request)
	{
		//validation
		// $this->validate($request, ['target'=>'required']);

		$input = $request->all(); 
		// dd($input);

		$line = $input['line'];
		$komesa = $input['komesa'];
		$style = $input['style'];
		$color = $input['color'];
		$req_type = $input['req_type'];

		if (empty($input['target'])) {
			$rel_po = DB::connection('sqlsrv1')->select(DB::raw("SELECT RIGHT([No_],6) as po FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] WHERE [Status] = '3'"));
			$msg = 'Target is required';
			return view('target.enter_target', compact('line','komesa', 'style', 'color', 'req_type', 'msg'));
		}

		$target = intval($input['target']);
		// dd($target);

		$date = date("Y.m.d");
		// dd($date);

		$key =  $date."#".$line."#".$req_type;
		// dd($key);

		

		try {
				$target_new = new target;
				$target_new->line = $line;
				$target_new->date = $date;
				$target_new->req_type = $req_type;
				$target_new->key = $key;

				$target_new->komesa = $komesa;
				$target_new->style = $style;
				$target_new->color = $color;
				
				$target_new->target_qty= $target;
				
				$target_new->save();
				// var_dump("1");
			}
		catch (\Illuminate\Database\QueryException $e) {
			
			//return view('bbstock.error');		
			
			$bb = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM targets WHERE [key] = '".$key."' "));
			// dd($bb[0]->id);

			if ($bb) {
			
			$target_old = target::findOrFail($bb[0]->id);
			
			// $target_old->line = $line;
			// $target_old->date = $date;
			// $target_old->req_type = $req_type;
			// $target_old->key = $key;


			$target_old->komesa = $komesa;
			$target_old->style = $style;
			$target_old->color = $color;
			
			$target_old->target_qty= $target;

			$target_old->save();
			// var_dump("2");

			}
			
		}

	
	return redirect('production');

	}
	
}
