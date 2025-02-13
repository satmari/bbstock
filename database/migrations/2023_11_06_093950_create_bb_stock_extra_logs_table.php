<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBbStockExtraLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bb_stock_extra_logs', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('bbcode');
			$table->string('bbname');

			$table->string('operation');
			$table->string('operation_id');
			$table->string('operation_type');
			$table->string('key');

			$table->string('status');
			$table->boolean('active')->default(1);

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
		Schema::drop('bb_stock_extra_logs');
	}

}
