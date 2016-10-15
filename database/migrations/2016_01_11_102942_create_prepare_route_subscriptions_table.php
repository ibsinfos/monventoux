<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrepareRouteSubscriptionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_prepare_route_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id');
            $table->integer('user_id')->nullable();
            $table->integer('option_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('street');
            $table->string('number');
            $table->string('postalcode');
            $table->string('city');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('dob');
            $table->enum('gender', ['M', 'V']);
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
        Schema::drop('website_prepare_route_subscriptions');
    }

}
