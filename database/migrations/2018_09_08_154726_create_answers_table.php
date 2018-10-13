<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id');

            $table->string('traceAId')->nullable();

            $table->text('button_mm3')->nullable();
            $table->longText('message_mm3')->nullable();

            $table->text('button_zg')->nullable();
            $table->longText('message_zg')->nullable();

            $table->text('button_en')->nullable();
            $table->longText('message_en')->nullable();

            $table->text('image')->nullable();
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
        Schema::dropIfExists('answers');
    }
}
