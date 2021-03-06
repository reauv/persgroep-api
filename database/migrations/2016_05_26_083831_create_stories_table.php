<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('atom_id')->nullable();
            $table->string('title');
			$table->text('excerpt')->nullable();
            $table->text('body')->nullable();
			$table->text('draft')->nullable();
            $table->string('image_url')->nullable();
        	$table->integer('user_id')->unsigned();
            $table->timestamps();
			$table->bigInteger('score')->default(0);

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::drop('stories');
    }
}
