<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForTimeoutToFbUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fb_users', function (Blueprint $table) {
            $table->timestamp('active_at')->default(now());
            $table->tinyInteger('timeout')->default(0);
            $table->index(['active_at', 'timeout']);
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
            $table->dropIndex(['active_at', 'timeout']);
            $table->dropColumn('active_at');
            $table->dropColumn('timeout');
        });
    }
}
