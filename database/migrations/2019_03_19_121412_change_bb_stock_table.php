<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBbStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('bbStock', function ($table) {


		 //$table->string('sku')->nullable();  //added later

		});

		Schema::table('bb_stock_logs', function ($table) {

			// $table->string('sku')->nullable();  //added later

		});

		Schema::table('bundlelogs', function ($table) {

			$table->string('pallet')->nullable();  //added later

		});

		Schema::table('deliveredlogs', function ($table) {

	
			$table->string('pallet')->nullable();  //added later

		});

		Schema::table('temploads', function ($table) {

	
			$table->string('pallet')->nullable();  //added later

		});

		Schema::table('temptransits', function ($table) {

	
			$table->string('pallet')->nullable();  //added later

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
