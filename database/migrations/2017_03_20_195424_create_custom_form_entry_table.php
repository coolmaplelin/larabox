<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFormEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_form_entry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->length(10)->unsigned();
            $table->text('form_fields')->nullable();
            $table->boolean('is_actioned')->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::table('custom_form_entry', function($table) {
            $table->foreign('form_id')->references('id')->on('custom_forms')->onDelete('cascade')->onUpdate('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_form_entry');
    }
}
