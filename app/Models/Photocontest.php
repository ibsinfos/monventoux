<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photocontest extends Model {

	//
    public $table = "website_photocontest";
    protected $fillable = array('name', 'surname', 'email', 'participant', 'picture', 'description');

    public function up()
    {
        Schema::create('photocontest', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('surname', 255);
            $table->string('email', 255);
            $table->string('participant', 255);
            $table->string('picture', 255);
            $table->text('description');
            $table->timestamps();
        });
    }
}
