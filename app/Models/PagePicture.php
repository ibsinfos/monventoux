<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagePicture extends Model
{

	public $table = "website_page_pictures";

	/**
	 * A picture is owned by a pictureSet
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function pictureSet()
	{
		return $this->belongsTo('App\Models\PagePictureSet', 'id');
	}

}
