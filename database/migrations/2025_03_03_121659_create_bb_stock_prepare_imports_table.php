<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBbStockPrepareImportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bb_stock_prepare_imports', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('pro');
			$table->string('extra_mat_skeda');
			$table->integer('qty_to_remove_from_stock');
			
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bb_stock_prepare_imports');
	}

}
