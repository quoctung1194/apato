<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceReCallTable extends Migration {
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    	Schema::create('service_re_calls', function (Blueprint $table) {
    		$table->increments('id');
    		$table->integer('service_id');
    		$table->integer('user_id');
    		$table->boolean('locked');
    		$table->string('note', 1000);
    		$table->timestamps();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        //
    }
}
