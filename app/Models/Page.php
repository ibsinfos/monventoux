<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = "website_pages";

    public function template()
    {
        return $this->belongsTo('App\Models\PageTemplate', 'template_id');
    }

    public function routes()
    {
        return $this->hasMany('App\Models\PrepareRoute', 'page_id');
    }

}
