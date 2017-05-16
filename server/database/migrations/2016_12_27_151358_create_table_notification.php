<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotification extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    	Schema::create('notifications', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('title');
    		$table->mediumText('content');
    		$table->tinyInteger('priority');
    		$table->tinyInteger('privacyType');
    		$table->dateTime('remindDate');	
    		$table->boolean('isStickyHome')->default(false);
    		$table->tinyInteger('notificationType')->default(false);
    		$table->softDeletes();
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
