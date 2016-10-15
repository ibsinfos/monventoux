<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
    public $table = "website_page_templates";

    public function page()
    {
        return $this->hasOne('App\Models\Page', 'template_id');
    }


}
