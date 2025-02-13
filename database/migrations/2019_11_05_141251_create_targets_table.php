<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('targets', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('line');
			$table->string('date');
			$table->string('req_type');
			$table->string('key')->unique();
			$table->string('komesa');
			$table->string('style')->nullable();
			$table->string('color')->nullable();
			$table->integer('target_qty');

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
		Schema::drop('targets');
	}

}
