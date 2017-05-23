<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSurveysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_surveys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('survey_options_id');
			$table->string('other_content', 500)->default('Empty');
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
		Schema::drop('user_surveys');
	}

}
