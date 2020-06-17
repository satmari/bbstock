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
		 Schema::table('bb_stock_prepares', function ($table) {


		$table->string('operation')->nullable();
		$table->string('operation_code')->nullable();

		// 	// $table->string('visible')->nullable(); //add
		// 	//$table->dropColumn('defect_type_status'); //drop
		// 	// $table->string('name', 50)->nullable()->change(); //change
  		//  //$table->renameColumn('defect_type_status', 'visible'); //rename

		// 	// $table->dropColumn('name_id'); //drop

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
