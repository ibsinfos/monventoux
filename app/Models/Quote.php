<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model {

	//
    public $table = "website_quotes";
    protected $fillable = array('name', 'img', 'txt');

    public function up()
    {
        Schema::create('newsitems', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('img', 255);
            $table->string('txt', 255);
            $table->timestamps();
        });
    }
}
