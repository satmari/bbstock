<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('temploads', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('bbcode');
			$table->string('bbname', 24)->unique();
			$table->string('po', 24);
			$table->string('style', 12);
			$table->string('color', 12);
			$table->string('size', 8);
			$table->integer('qty');
			$table->dateTime('boxdate');
			$table->tinyInteger('numofbb');
			$table->string('location', 24);

			$table->string('status',24)->nullable();  //added later
			$table->double('pitch_time')->nullable();  //added later

			$table->string('bagno')->nullable();  //added later
			$table->string('pallet')->nullable();  //added later

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
		Schema::drop('temploads');
	}

}
