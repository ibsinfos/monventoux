<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrepareRouteOption extends Model {

    public $table = "website_prepare_route_options";

    public function route()
    {
        return $this->belongsTo('App\Models\PrepareRoute', 'route_id');
    }

}
