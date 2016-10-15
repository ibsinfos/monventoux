<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrepareRoute extends Model
{

    public $table = "website_prepare_routes";

    public function page()
    {
        return $this->hasOne('App\Models\Page', 'page_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\PrepareRouteSubscription', 'route_id');
    }

    public function options()
    {
        return $this->hasMany('App\Models\PrepareRouteOption', 'route_id');
    }

}
