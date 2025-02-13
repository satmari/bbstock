<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemppreparesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tempprepares', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('bbcode');
			$table->string('bbname')->unique();
			$table->string('inteosdb');
			$table->string('rnumber');
			$table->string('username');
			$table->string('f');

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
		Schema::drop('tempprepares');
	}

}
