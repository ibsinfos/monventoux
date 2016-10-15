<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagePictureSet extends Model
{
	public $table = "website_page_picture_sets";

	/**
	 * A pictureSet can have many pictures
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */
	public function picturesetpictures()
	{
		return $this->hasMany('App\Models\PagePicture', 'set_id');
	}

}
