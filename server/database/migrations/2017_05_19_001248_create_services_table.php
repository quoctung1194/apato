<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->string('image', 100)->default('');
			$table->string('url', 500);
			$table->string('phone', 50)->default('');
			$table->string('content', 1000);
			$table->boolean('re_call')->default(1);
			$table->integer('provider_service_type_id');
			$table->date('start_at')->nullable();
			$table->date('end_at')->nullable();
			$table->boolean('locked')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('services');
	}

}
