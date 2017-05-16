<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceApartmentsTable extends Migration {
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    	Schema::create('service_apartments', function (Blueprint $table) {
    		$table->increments('id');
    		$table->integer('service_id');
    		$table->integer('apartment_id');
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
