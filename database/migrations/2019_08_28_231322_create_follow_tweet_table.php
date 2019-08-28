<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowTweetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_tweet', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('tweet_id')->unsigned();
            $table->primary(array('user_id', 'tweet_id'));
        });

        Schema::table('follow_tweet', function($table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('tweet_id')->references('id')->on('tweets')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_tweet');
    }
}
