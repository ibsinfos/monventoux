<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrepareRouteSubscription extends Model
{
    public $table = "website_prepare_route_subscriptions";

    public function route()
    {
        return $this->belongsTo('App\Models\PrepareRoute', 'route_id');
    }

}
