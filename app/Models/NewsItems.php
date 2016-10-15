<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItems extends Model {

	//
    public $table = "website_news";
    protected $fillable = array('title', 'intro', 'body', 'picture', 'start', 'end');

    public function up()
    {
        Schema::create('newsitems', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('intro');
            $table->text('body');
            $table->string('picture', 255);
            $table->dateTime('start')->default(date('Y-m-d H:i:s'));
            $table->dateTime('end')->default('0000-00-00 00:00:00');
            $table->timestamps();
        });
    }
}
