<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableForAdminResidential extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('gender')->default(0);
            $table->string('phone', 50);
            $table->string('id_card', 12);
            $table->string('magnetic_card_code', 50);
            $table->timestamp('birthday');
            $table->boolean('married');
            $table->integer('population');
            $table->boolean('family_register_status');
            $table->timestamp('start_at')->nullable();
            $table->string('note', 1000);
            $table->boolean('locked');
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
