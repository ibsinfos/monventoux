<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrSet extends Model {

    public function pictures()
    {
        return $this->hasMany('App\Models\FlickrPicture', 'set_id');
    }

}
