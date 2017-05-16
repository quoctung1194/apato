<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServeyOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
		Schema::create('survey_options', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('notification_id');
			$table->string('content', 500);
			$table->boolean('is_other');
			$table->string('color', 30);
			$table->timestamps();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
