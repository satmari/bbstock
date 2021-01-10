<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePrepareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 // Schema::table('bb_stock_prepares', function ($table) {


		// $table->string('operation')->nullable();
		// $table->string('operation_code')->nullable();

		// 	// $table->string('visible')->nullable(); //add
		// 	//$table->dropColumn('defect_type_status'); //drop
		// 	// $table->string('name', 50)->nullable()->change(); //change
  		//  //$table->renameColumn('defect_type_status', 'visible'); //rename

		// 	// $table->dropColumn('name_id'); //drop

		// });

		// Schema::table('bbStock', function ($table) {

		//  	$table->string('bagno')->nullable();  //added later

		// });	

		// Schema::table('bb_stock_logs', function ($table) {

		//  	$table->string('bagno')->nullable();  //added later
		 	
		// });	

		// Schema::table('bundlelogs', function ($table) {

		//  	$table->string('bagno')->nullable();  //added later
		 	
		// });	

		// Schema::table('deliveredlogs', function ($table) {

		//  	$table->string('bagno')->nullable();  //added later
		 	
		// });	

		// Schema::table('temploads', function ($table) {

		// 	$table->string('bagno')->nullable();  //added later
		 	
		// });	

		// Schema::table('temptransits', function ($table) {

		// 	$table->string('bagno')->nullable();  //added later
		 	
		// });
		
		Schema::table('locations', function ($table) {

			$table->string('location_dest')->nullable();  //added later
		 	
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
