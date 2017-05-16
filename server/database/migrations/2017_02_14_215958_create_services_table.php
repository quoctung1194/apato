<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('services', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('name', 100);
    		$table->string('image', 100);
    		$table->string('url', 100);
    		$table->string('content', 1000);
    		$table->string('phone', 50);
    		$table->integer('service_type_id');
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
        //
    }
}
