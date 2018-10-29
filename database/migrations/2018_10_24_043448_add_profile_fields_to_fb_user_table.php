<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFieldsToFbUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fb_users', function (Blueprint $table) {
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->text('profilePic')->nullable();
            $table->string('locale')->nullable();
            $table->string('timezone')->nullable();
            $table->string('gender')->nullable();
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
            $table->dropColumn('firstName');
            $table->dropColumn('lastName');
            $table->dropColumn('profilePic');
            $table->dropColumn('locale');
            $table->dropColumn('timezone');
            $table->dropColumn('gender');
        });
    }
}
