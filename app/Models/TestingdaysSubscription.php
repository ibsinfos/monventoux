<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestingdaysSubscription extends Model
{
    public $table = "website_testingdays_subscriptions";

    public function page()
    {
        return $this->hasOne('App\Models\User', 'sadn_id');
    }


}
