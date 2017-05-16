<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockTable extends Migration {
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    	Schema::create('blocks', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('name');
    		$table->integer('apartment_id');
    		$table->boolean('locked');
    		$table->timestamps();
    		$table->softDeletes();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
		
    }
}
