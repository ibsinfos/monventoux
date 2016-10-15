<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFrontPagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_front_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('blade_file');
            $table->string('title');
            $table->string('subtitle');
            $table->string('image');
            $table->boolean('active')->default(0);
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
        Schema::drop('website_front_pages');
    }

}
