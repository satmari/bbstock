<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBbStockLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bb_stock_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('bbcode');
			$table->string('bbname');
			$table->string('po');
			$table->string('style');
			$table->string('color');
			$table->string('size');
			$table->integer('qty');
			$table->dateTime('boxdate');
			$table->tinyInteger('numofbb');
			$table->string('location');
			
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
		Schema::drop('bb_stock_logs');
	}

}
