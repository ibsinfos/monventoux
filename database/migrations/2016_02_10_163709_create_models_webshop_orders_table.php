<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsWebshopOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webshop_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->text('products');
            $table->string('subtotal');
            $table->string('discount');
            $table->string('total');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('cb_membernr');
            $table->boolean('send');
            $table->string('location');
            $table->string('address');
            $table->string('postalcode');
            $table->string('city');
            $table->string('country');
            $table->string('phone');
            $table->string('email');
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
        Schema::drop('webshop_orders');
    }

}
