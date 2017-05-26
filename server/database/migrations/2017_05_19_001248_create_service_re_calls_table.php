<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceReCallsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_re_calls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('service_id');
			$table->integer('user_id');
			$table->boolean('locked')->default(0);
			$table->string('note', 1000);
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
		Schema::drop('service_re_calls');
	}

}
