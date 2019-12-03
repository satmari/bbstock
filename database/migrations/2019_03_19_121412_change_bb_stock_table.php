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

			
			// $table->double('pitch_time')->nullable();  //added later
	 		//$table->dropColumn('defect_type_status'); //drop
	 		// $table->string('name', 50)->nullable()->change(); //change
   			//$table->renameColumn('defect_type_status', 'visible'); //rename
	 		// $table->string('status',24);

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
