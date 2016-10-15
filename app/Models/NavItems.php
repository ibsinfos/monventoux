<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavItems extends Model {

    public $table = "website_menu_items";

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id');
    }

}
