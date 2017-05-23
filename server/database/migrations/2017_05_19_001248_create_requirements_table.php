<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequirementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requirements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->integer('type_id');
			$table->integer('tag_id');
			$table->string('description', 1000);
			$table->boolean('is_repeat_problem');
			$table->integer('user_id');
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
		Schema::drop('requirements');
	}

}
