<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebshopOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_webshop_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mail');
            $table->string('name');
            $table->string('lastname');
            $table->string('streetname');
            $table->string('number');
            $table->string('zip');
            $table->string('state');
            $table->string('country');
            $table->string('delivering');
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
        Schema::drop('website_webshop_order');
    }
}
