<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConversationModeToFbUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fb_users', function (Blueprint $table) {
            $table->tinyInteger('conversation')->default(0);
            $table->tinyInteger('seen')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fb_users', function (Blueprint $table) {
            $table->dropColumn('conversation');
            $table->dropColumn('seen');
        });
    }
}
