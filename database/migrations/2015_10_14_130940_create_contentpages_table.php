<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('menulabel');
            $table->enum('active', array(0,1))->default(0);
            $table->text('intro')->nullable();
            $table->text('body');
            $table->integer('template_id')->default(1);
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
        Schema::drop('website_pages');
    }
}
