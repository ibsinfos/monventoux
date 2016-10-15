<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrPicture extends Model
{

    public function set()
    {
        return $this->belongsTo('App\Models\FlickrSet', 'set_id');
    }

}
