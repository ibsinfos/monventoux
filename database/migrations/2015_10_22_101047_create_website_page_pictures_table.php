<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitePagePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_page_pictures', function (Blueprint $table) {
            //
            $table -> increments('id');
            $table -> string('small_image_name');
            $table -> string('large_image_name');
            $table -> integer('set_id');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('website_page_pictures');
    }
}
