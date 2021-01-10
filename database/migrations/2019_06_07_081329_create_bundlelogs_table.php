<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundlelogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bundlelogs', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('bbcode')->nullable();
			$table->string('bbname', 24)->nullable();
			$table->string('po', 24)->nullable();
			$table->string('style', 12)->nullable();
			$table->string('color', 12)->nullable();
			$table->string('size', 8)->nullable();
			$table->integer('qty')->nullable();
			$table->dateTime('boxdate')->nullable();
			$table->tinyInteger('numofbb')->nullable();
			$table->string('location', 24)->nullable();

			$table->string('status',24)->nullable();

			$table->string('bagno')->nullable();  //added later
			
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
		Schema::drop('bundlelogs');
	}

}
