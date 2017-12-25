<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class QueryController extends Controller {

	public function search(Request $request)
	{
   		// Gets the query string from our form submission 
    	$query = Request::input('search');
    	// Returns an array of articles that have the query string located somewhere within 
    	// our articles titles. Paginates them so we can break up lots of search results.
  		//$articles = DB::table('articles')->where('title', 'LIKE', '%' . $query . '%')->paginate(10);
  		//$articles = DB::table('articles')->where('title', 'LIKE', '%' . $query . '%')->paginate(10);
  		$articles = DB::connection('sqlsrv2')->select(DB::raw("SELECT [CNF_BlueBox].INTKEY,[CNF_BlueBox].IntKeyPO,[CNF_BlueBox].BlueBoxNum,[CNF_BlueBox].BoxQuant, [CNF_PO].POnum,[CNF_SKU].Variant,[CNF_SKU].ClrDesc,[CNF_STYLE].StyCod FROM [BdkCLZGtest].[dbo].[CNF_BlueBox] FULL outer join [BdkCLZGtest].[dbo].CNF_PO on [CNF_PO].INTKEY = [CNF_BlueBox].IntKeyPO FULL outer join [BdkCLZGtest].[dbo].[CNF_SKU] on [CNF_SKU].INTKEY = [CNF_PO].SKUKEY FULL outer join [BdkCLZGtest].[dbo].[CNF_STYLE] on [CNF_STYLE].INTKEY = [CNF_SKU].STYKEY WHERE [CNF_BlueBox].INTKEY =  :somevariable"), array(
			'somevariable' => $query,
		));
        
		// returns a view and passes the view the list of articles and the original query.
    	return view('page.search', compact('articles', 'query'));

 	}
	

}
