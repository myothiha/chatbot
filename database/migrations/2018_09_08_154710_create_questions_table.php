<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id');

            $table->unsignedInteger('type');
            $table->string('traceQId')->default(null);
            $table->string('tracePId')->default(null);

            $table->text('button_mm3');
            $table->longText('message_mm3');

            $table->text('button_zg');
            $table->longText('message_zg');

            $table->text('button_en');
            $table->longText('message_en');

            $table->text('image')->default(null);
            $table->unsignedTinyInteger('status')->default(1);

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
        Schema::dropIfExists('questions');
    }
}
