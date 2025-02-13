<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBbStockPreparesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bb_stock_prepares', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('bbcode');
			$table->string('bbname');
			$table->string('inteosdb');
			$table->string('rnumber');
			$table->string('username');
			$table->string('f');

			$table->string('po');
			$table->string('style');
			$table->string('color');
			$table->string('size');
			$table->integer('qty');
			$table->string('bagno');

			$table->string('operation')->nullable; //later
			$table->string('operation_code')->nullable; //later

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
		Schema::drop('bb_stock_prepares');
	}

}
