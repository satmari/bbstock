<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraStyleSizesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('extra_style_sizes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('style');
			$table->string('size');
			$table->string('style_size');
			
			$table->string('operation');
			$table->string('operation_id');
			$table->string('key')->unique();
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
		Schema::drop('extra_style_sizes');
	}

}
