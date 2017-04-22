<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceCallsTable extends Migration {
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    	Schema::create('service_calls', function (Blueprint $table) {
    		$table->increments('id');
    		$table->integer('service_id');
    		$table->integer('user_id');
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
