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
		$people = bbStock::all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(\Schema::getColumnListing('bbstock'));

        foreach ($people as $person) {
            $csv->insertOne($person->toArray());
        }

        $csv->output('bbstock.csv');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
