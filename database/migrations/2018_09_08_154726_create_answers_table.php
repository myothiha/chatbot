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

            $table->unsignedInteger('type');
            $table->string('traceAId')->default(null);

            $table->text('button_mm3');
            $table->longText('message_mm3');

            $table->text('button_zg');
            $table->longText('message_zg');

            $table->text('button_en');
            $table->longText('message_en');

            $table->text('image')->default(null);
            $table->unsignedTinyInteger('status')->default(1);

            $table->timestamps();

            $table->foreign('question_id')
                  ->references('id')->on('questions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
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
