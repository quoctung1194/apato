<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('block_id')
                ->after('apartment_id')
                ->nullable();
            $table->integer('floor_id')
                ->after('block_id')
                ->nullable();
            $table->integer('room_id')
                ->after('floor_id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('block_id');
            $table->dropColumn('floor_id');
            $table->dropColumn('room_id');
        });
    }
}
