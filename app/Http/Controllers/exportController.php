<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Excel;
use App\bbStock;
use DB;

class exportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/*
		public function export() {
			$posts = bbStock::all();
			$headers = $this-&gt;getColumnNames($posts);
			$posts_array = array_merge((array)$headers, (array)$posts-&gt;toArray());
		}

		public function getColumnNames($object) {
			$rip_headers = $object-&gt;toArray();
			$keys = array_keys($rip_headers[0]);

			foreach ($keys as $value) {
				$headers[$value] = $value;
			}

			return array($headers);
		}

		Excel::create('Filename')->sheet('bbStock')->with($posts_array)->export('xlsx');
		*/
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$list = bbStock::all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(\Schema::getColumnListing('bbstock'));

        foreach ($list as $line) {
            $csv->insertOne($line->toArray());
        }

        $csv->output('bbstock.csv');
	}

	
}
