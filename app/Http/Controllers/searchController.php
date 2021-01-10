<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use DB;

class searchController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view('search.index');
	}

	public function index2()
	{
		//
		return view('search.index2');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search(Request $request)
	{
		//
		//remove BB
		//validation
		//$this->validate($request, ['bb_code'=>'required|max:10']);
		$this->validate($request, ['po'=>'min:6|max:6']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		//$bb_code = $input['bb_code'];
		$po = $input['po'];
		$size = $input['size'];

		// Search -----------------------------------------------------
		// serach by bb_code
		//$search = bbStock::where('bbcode', '=', $bb_code)->first();

		$q = bbStock::query();

		if ($po) {
			$q->searchpo($po);
		}

		if ($size) {
			$q->searchsize($size);
		}

		$search = $q->get()->sortByDesc('location');
		
		// if ($po) {
		// 	$search1 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE po = ".$po." ORDER BY boxdate"));
		// } else if ($size) {
		// 	$search1 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE size = ".$size));
		// } else {
		// 	$search1 = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock "));
		// }

		if ($search == false) {
		 	return view('search.error'); //1971107960
		} else {
			//return view('search.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			return view('search.success', compact('search'));
		}

	}

	public function search2(Request $request)
	{
		//
		//remove BB
		//validation
		//$this->validate($request, ['bb_code'=>'required|max:10']);
		$this->validate($request, ['po'=>'min:6|max:6']);

		$input = $request->all(); // change use (delete or comment user Requestl; )
		//var_dump($inteosinput);

		//$bb_code = $input['bb_code'];
		$po = $input['po'];
		$size = $input['size'];


		$q = bbStock::query();

		if ($po) {
			$q->searchpo($po);
		}

		if ($size) {
			$q->searchsize($size);
		}

		$search = $q->get()->sortByDesc('location');
		$search_by_date = $q->get()->sortBy('boxdate');

		// Search -----------------------------------------------------
		/*
		if (($input['po']) AND ($input['size'])) {
			$po = $input['po'];
			$size = $input['size'];
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE po = ".$po." AND size = ".$size." ORDER BY boxdate"));

		} else if ($input['po']) {
			$po = $input['po'];
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE po = ".$po." ORDER BY boxdate"));

		} else if ($input['size']) {
			$size = $input['size'];
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock WHERE size = ".$size." ORDER BY boxdate"));

		} else {
			$search = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM bbStock ORDER BY boxdate"));
		}
		*/

		if ($search == false) {
		 	return view('search.error'); //1971107960
		} else {
			//return view('search.success', compact('bbname','po','style','color','size','qty','numofbb','location'));
			return view('search.success2', compact('search','search_by_date'));
		}


	}

	// New search
	public function searchbypo()
	{

		return view('search.searchbypo');
	}

	public function searchbypopost(Request $request)
	{
		$input = $request->all();
		// dd($input);
		$this->validate($request, ['po'=>'min:6|max:6|required']);
		$po = $input['po'];

		$data = DB::connection('sqlsrv2')->select(DB::raw("SELECT       bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 bb.Bagno,
			 m.ModNam,
			 (CASE WHEN bb.[Status] = '0' THEN 'New' WHEN bb.[Status] = '30' THEN 'Suspended' WHEN bb.[Status] = '10' THEN 'On Module' WHEN bb.[Status] = '99' THEN 'Completed'
             WHEN bb.[Status] = '20' THEN 'In Use' END) AS Status,
             bb.CREATEDATE,
             po.POnum,
             po.SKUKEY,
             sku.Variant,
             sku.STYKEY,
             st.StyCod,
             bb.BoxQuant - bb.Produced - bb.Scrap - bb.WIP AS Balance,
             (SELECT        COUNT(INTKEY) AS Expr1
             FROM            CNF_SkuExtraOperations
             WHERE        (SKUKEY = sku.INTKEY)) AS SkuExtraOperations,
             
             (SELECT        COUNT(BB_INTKEY) AS Expr1
             FROM            CNF_BBExtraOperations
             WHERE        (BB_INTKEY = bb.INTKEY)) AS BBExtraOperations, 
             SUBSTRING(bb.BlueBoxNum, 1, 14) AS ProdOrder
             
             ,(SELECT status FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_status
             ,(SELECT location FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_location
             
             
             
FROM         CNF_BlueBox AS bb LEFT OUTER JOIN
             CNF_PO AS po ON bb.IntKeyPO = po.INTKEY LEFT OUTER JOIN
             CNF_SKU AS sku ON po.SKUKEY = sku.INTKEY LEFT OUTER JOIN
             CNF_STYLE AS st ON sku.STYKEY = st.INTKEY LEFT OUTER JOIN
             CNF_Modules AS m ON bb.Module = m.Module
                         
WHERE		 bb.[Status] != '99'  and bb.BoxQuant != '0'  and 
			 (po.POClosed != '1'  OR po.POClosed IS NULL) and po.POnum like '%".$po."%'
			 
GROUP BY	 bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 bb.Status,
			 bb.CREATEDATE,
			 bb.Bagno,
			 po.POnum,
			 po.SKUKEY,
			 sku.Variant,
			 sku.STYKEY,
			 st.StyCod,
			 m.ModNam,
			 sku.INTKEY,
			 bb.INTKEY

UNION ALL

SELECT       bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 bb.Bagno,
			 m.ModNam,
			 (CASE WHEN bb.[Status] = '0' THEN 'New' WHEN bb.[Status] = '30' THEN 'Suspended' WHEN bb.[Status] = '10' THEN 'On Module' WHEN bb.[Status] = '99' THEN 'Completed'
             WHEN bb.[Status] = '20' THEN 'In Use' END) AS Status,
             bb.CREATEDATE,
             po.POnum,
             po.SKUKEY,
             sku.Variant,
             sku.STYKEY,
             st.StyCod,
             bb.BoxQuant - bb.Produced - bb.Scrap - bb.WIP AS Balance,
             (SELECT        COUNT(INTKEY) AS Expr1
             FROM            [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_SkuExtraOperations
             WHERE        (SKUKEY = sku.INTKEY)) AS SkuExtraOperations,
             
             (SELECT        COUNT(BB_INTKEY) AS Expr1
             FROM            [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_BBExtraOperations
             WHERE        (BB_INTKEY = bb.INTKEY)) AS BBExtraOperations, 
             SUBSTRING(bb.BlueBoxNum, 1, 14) AS ProdOrder
             
             ,(SELECT status FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_status
             ,(SELECT location FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_location
             
FROM         [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_BlueBox AS bb LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_PO AS po ON bb.IntKeyPO = po.INTKEY LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_SKU AS sku ON po.SKUKEY = sku.INTKEY LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_STYLE AS st ON sku.STYKEY = st.INTKEY LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_Modules AS m ON bb.Module = m.Module
                         
WHERE		 bb.[Status] != '99'  and bb.BoxQuant != '0'  and 
			 (po.POClosed != '1'  OR po.POClosed IS NULL) and po.POnum like '%".$po."%'
			 
GROUP BY	 bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 bb.Status,
			 bb.CREATEDATE,
			 bb.Bagno,
			 po.POnum,
			 po.SKUKEY,
			 sku.Variant,
			 sku.STYKEY,
			 st.StyCod,
			 m.ModNam,
			 sku.INTKEY,
			 bb.INTKEY

ORDER BY bb.BlueBoxNum asc, bb.CREATEDATE"));
	
	// dd($data);

		return view('search.searchbypotable', compact('data', 'po'));
	}

	public function searchbybb()
	{

		return view('search.searchbybb');
	}

	public function searchbybbpost(Request $request)
	{
		$input = $request->all();
		// dd($input);
		$this->validate($request, ['bb'=>'required']);
		$bb = $input['bb'];


		$findpo = DB::connection('sqlsrv')->select(DB::raw("SELECT po FROM bbStock WHERE bbcode = '".$bb."' "));
		// dd($findpo);

		if (isset($findpo[0])) {
			$po = $findpo[0]->po;

		} else {
			dd("Can not find PO from this BB");
		}



		$data = DB::connection('sqlsrv2')->select(DB::raw("SELECT       bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 m.ModNam,
			 (CASE WHEN bb.[Status] = '0' THEN 'New' WHEN bb.[Status] = '30' THEN 'Suspended' WHEN bb.[Status] = '10' THEN 'On Module' WHEN bb.[Status] = '99' THEN 'Completed'
             WHEN bb.[Status] = '20' THEN 'In Use' END) AS Status,
             bb.CREATEDATE,
             po.POnum,
             po.SKUKEY,
             sku.Variant,
             sku.STYKEY,
             st.StyCod,
             bb.BoxQuant - bb.Produced - bb.Scrap - bb.WIP AS Balance,
             (SELECT        COUNT(INTKEY) AS Expr1
             FROM            CNF_SkuExtraOperations
             WHERE        (SKUKEY = sku.INTKEY)) AS SkuExtraOperations,
             
             (SELECT        COUNT(BB_INTKEY) AS Expr1
             FROM            CNF_BBExtraOperations
             WHERE        (BB_INTKEY = bb.INTKEY)) AS BBExtraOperations, 
             SUBSTRING(bb.BlueBoxNum, 1, 14) AS ProdOrder
             
             ,(SELECT status FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_status
             ,(SELECT location FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_location
             
             
             
FROM         CNF_BlueBox AS bb LEFT OUTER JOIN
             CNF_PO AS po ON bb.IntKeyPO = po.INTKEY LEFT OUTER JOIN
             CNF_SKU AS sku ON po.SKUKEY = sku.INTKEY LEFT OUTER JOIN
             CNF_STYLE AS st ON sku.STYKEY = st.INTKEY LEFT OUTER JOIN
             CNF_Modules AS m ON bb.Module = m.Module
                         
WHERE		 bb.[Status] != '99'  and bb.BoxQuant != '0'  and 
			 (po.POClosed != '1'  OR po.POClosed IS NULL) and po.POnum like '%".$po."%'
			 
GROUP BY	 bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 bb.Status,
			 bb.CREATEDATE,
			 po.POnum,
			 po.SKUKEY,
			 sku.Variant,
			 sku.STYKEY,
			 st.StyCod,
			 m.ModNam,
			 sku.INTKEY,
			 bb.INTKEY

UNION ALL

SELECT       bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 m.ModNam,
			 (CASE WHEN bb.[Status] = '0' THEN 'New' WHEN bb.[Status] = '30' THEN 'Suspended' WHEN bb.[Status] = '10' THEN 'On Module' WHEN bb.[Status] = '99' THEN 'Completed'
             WHEN bb.[Status] = '20' THEN 'In Use' END) AS Status,
             bb.CREATEDATE,
             po.POnum,
             po.SKUKEY,
             sku.Variant,
             sku.STYKEY,
             st.StyCod,
             bb.BoxQuant - bb.Produced - bb.Scrap - bb.WIP AS Balance,
             (SELECT        COUNT(INTKEY) AS Expr1
             FROM            [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_SkuExtraOperations
             WHERE        (SKUKEY = sku.INTKEY)) AS SkuExtraOperations,
             
             (SELECT        COUNT(BB_INTKEY) AS Expr1
             FROM            [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_BBExtraOperations
             WHERE        (BB_INTKEY = bb.INTKEY)) AS BBExtraOperations, 
             SUBSTRING(bb.BlueBoxNum, 1, 14) AS ProdOrder
             
             ,(SELECT status FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_status
             ,(SELECT location FROM [172.27.161.221\GPD].[bbStock].[dbo].[bbStock] AS bbstock WHERE bbstock.bbname = bb.BlueBoxNum) as BBStock_location
             
FROM         [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_BlueBox AS bb LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_PO AS po ON bb.IntKeyPO = po.INTKEY LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_SKU AS sku ON po.SKUKEY = sku.INTKEY LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_STYLE AS st ON sku.STYKEY = st.INTKEY LEFT OUTER JOIN
             [172.27.161.221\INTEOSKKA].[BdkCLZKKA].[dbo].CNF_Modules AS m ON bb.Module = m.Module
                         
WHERE		 bb.[Status] != '99'  and bb.BoxQuant != '0'  and 
			 (po.POClosed != '1'  OR po.POClosed IS NULL) and po.POnum like '%".$po."%'
			 
GROUP BY	 bb.IntKeyPO,
			 bb.BlueBoxNum,
			 bb.BoxQuant,
			 bb.Produced,
			 bb.Qual2,
			 bb.WIP,
			 bb.Scrap,
			 bb.IDMarker,
			 bb.Status,
			 bb.CREATEDATE,
			 po.POnum,
			 po.SKUKEY,
			 sku.Variant,
			 sku.STYKEY,
			 st.StyCod,
			 m.ModNam,
			 sku.INTKEY,
			 bb.INTKEY

ORDER BY bb.BlueBoxNum asc, bb.CREATEDATE"));
	
	// dd($data);

		return view('search.searchbybbtable', compact('data', 'po'));
	}


	

}
