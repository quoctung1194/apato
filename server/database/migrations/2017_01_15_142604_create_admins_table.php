<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    	Schema::create('admins', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('username', 50)->unique();
    		$table->string('password', 100);
    		$table->string('email', 100)->unique();
    		$table->boolean('is_super_admin')->default(false);
    		$table->integer('apartment_id')->default(-1);
    		$table->rememberToken();
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
        //
    }
}
