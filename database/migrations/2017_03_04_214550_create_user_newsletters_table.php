<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_newsletters', function (Blueprint $table) {
            $table->integer('user_id')->length(10)->unsigned();
            $table->integer('newsletter_id')->length(10)->unsigned();
            $table->primary(['user_id', 'newsletter_id']);
            $table->engine = 'InnoDB';
        });

        Schema::table('user_newsletters', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('newsletter_id')->references('id')->on('newsletters')->onDelete('cascade')->onUpdate('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_newsletters');
    }
}
