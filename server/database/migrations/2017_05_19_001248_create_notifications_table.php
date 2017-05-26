<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->default('Empty');
			$table->string('subTitle')->default('Empty');
			$table->text('content', 16777215);
			$table->boolean('privacyType')->default(0);
			$table->dateTime('remindDate')->nullable();
			$table->boolean('isStickyHome')->default(0);
			$table->boolean('notificationType')->default(0);
			$table->integer('apartment_id')->nullable();
			$table->boolean('type_check')->default(0);
			$table->softDeletes();
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
		Schema::drop('notifications');
	}

}
