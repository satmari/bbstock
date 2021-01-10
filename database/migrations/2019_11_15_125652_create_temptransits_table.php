<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemptransitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('temptransits', function(Blueprint $table)
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
		Schema::drop('temptransits');
	}

}


/*

location

'BlueBoxCode' => $bbcode,
'BlueBoxNum' => $BlueBoxNum,
'POnum' => $POnum,
'StyCod' => $StyCod
'Variant' => $Variant,
'BoxQuant' => $BoxQuant,
'BoxDate' => $BoxDate,


'BoxDateTemp' => $BoxDateTemp,
'IntKeyPO' => $IntKeyPO,

'SMVloc' => $SMVloc,

'ClrDesc' => $ClrDesc,


$bbStock->bbcode = $bbcode;
$bbStock->bbname = $bbname;
$bbStock->po = $po;

$bbStock->style = $style;
$bbStock->color = $color;
$bbStock->size = $size;
$bbStock->qty = $qty;
$bbStock->boxdate = $boxdate;

$bbStock->numofbb = $numofbb;

$bbStock->location = $location;

$bbStock->status = $status;
$bbStock->pitch_time = round($smv / 20 * $qty, 3);

*/