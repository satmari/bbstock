<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempextra2sTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tempextra2s', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('bbcode');
			$table->string('bbname');
			$table->string('operation');
			$table->string('operation_id');
			$table->string('operation_type');
			$table->string('ses');
			$table->string('key')->unique();
			
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
		Schema::drop('tempextra2s');
	}

}
