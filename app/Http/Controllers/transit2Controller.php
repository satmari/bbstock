<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\bbStock;
use App\locations;
use App\bb_stock_log;
use App\temptransit;

use DB;
use Log;

use Session;

class transit2Controller extends Controller {

	public function index()
	{
		//
		return view('transit2.index');
	}

	
}
