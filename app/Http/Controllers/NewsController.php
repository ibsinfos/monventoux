<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\NewsItems;
use App\Http\Controllers\Controller;
use View;
use Input;
use Illuminate\Database\Query\Builder;

use Request;

class NewsController extends Controller {
	use ControllerUtils;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$data['bodyclass'] = 'auth';
		$data['navigation'] = $this->_getMenuItems();
		$data['footernavigation'] = $this->_getFooterMenuItems();
		$data['event'] = $this->_getEventData();

		$data['newsitems'] = NewsItems::orderBy('start', 'desc')->get();

		return View::make('admin.news.index',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$data['bodyclass'] = 'auth';
		$data['navigation'] = $this->_getMenuItems();
		$data['footernavigation'] = $this->_getFooterMenuItems();
		$data['event'] = $this->_getEventData();

		return View::make('admin.news.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// get the values
		$input = Request::all();

		$image = Input::file('picture');
		//print_r($image);
		$imagename = $image->getClientOriginalName();

		//upload file
		if(isset($input['picture'])){
			if (Input::file('picture')->isValid()) {
				$destinationPath = 'images/nieuwsitems'; // upload path
				$fileName = $imagename; // renameing image
				$source=Input::file('picture');
				$destination=$destinationPath.'/'.$fileName;

				$quality=100;
				list($width, $height, $type, $attr) = getimagesize($source);

				//echo '<br>width: '.$width;
				//echo '<br>height: '.$height;

				if($width > $height) {
					//make it 800 width and height dependent
					$newwidth = 800;
					$newheight = $height*$newwidth/$width;
				} else {
					$newheight = 150;
					$newwidth = $width*$newheight/$height;
				}
				$off_x = $off_y = 0;

				//echo '<br>newwidth: '.$newwidth;
				//echo '<br>newheight: '.$newheight;
				//exit();

				$thumb_p    = imagecreatetruecolor($newwidth, $newheight);

				$extension  = Input::file('picture')->getClientOriginalExtension();
				$extension=strtolower($extension);

				if($extension == "gif" or $extension == "png" or $extension == "jpg"){

					imagecolortransparent($thumb_p, imagecolorallocatealpha($thumb_p, 0, 0, 0, 127));
					imagealphablending($thumb_p, false);
					imagesavealpha($thumb_p, true);
				}

				if ($extension == 'jpg' || $extension == 'jpeg')
					$thumb = imagecreatefromjpeg($source);
				if ($extension == 'gif')
					$thumb = imagecreatefromgif($source);
				if ($extension == 'png')
					$thumb = imagecreatefrompng($source);

				$bg = imagecolorallocate ( $thumb_p, 255, 255, 255 );
				imagefill ($thumb_p, 0, 0, $bg);

				imagecopyresampled($thumb_p, $thumb, 0, 0, $off_y, $off_x, $newwidth, $newheight, $width, $height);
				if ($extension == 'jpg' || $extension == 'jpeg')
					@imagejpeg($thumb_p,$destination,$quality);
				if ($extension == 'gif')
					@imagegif($thumb_p,$destination,$quality);
				if ($extension == 'png')
					@imagepng($thumb_p,$destination,9);

				imagedestroy($thumb);
				imagedestroy($thumb_p);
			}
		}

		// store the newsitem
		$item = new NewsItems;
		$item->title = $input['title'];
		$item->intro = $input['intro'];
		$item->body = $input['body'];
		if($imagename <> '') {
			$item->picture = 'images/nieuwsitems/' . $imagename;
		}
		$item->start = date_format(date_create_from_format('d/m/Y', $input['startdate']), 'Y-m-d') . ' ' . $input['starttime'];
		if($input['enddate'] == '00/00/0000'){
			$item->end = '0000-00-00 00:00:00';
		}else {
			$item->end = date_format(date_create_from_format('d/m/Y', $input['enddate']), 'Y-m-d') . ' ' . $input['endtime'];
		}

		$item->save();
		
		return redirect('admin/nieuwsbeheer');
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$data['bodyclass'] = 'auth';
		$data['navigation'] = $this->_getMenuItems();
		$data['footernavigation'] = $this->_getFooterMenuItems();
		$data['event'] = $this->_getEventData();

		$data['item'] = NewsItems::findOrFail($id);

		return View::make('admin.news.show',$data);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$data['bodyclass'] = 'auth';
		$data['navigation'] = $this->_getMenuItems();
		$data['footernavigation'] = $this->_getFooterMenuItems();
		$data['event'] = $this->_getEventData();

		$data['item'] = NewsItems::findOrFail($id);

		return View::make('admin.news.edit',$data);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//dd($id);
		//
		$imagename = '';

		// get the values
		$input = Request::all();

		$newimage=false;
		$image = Input::file('picture');
		//print_r($image);

		//upload file
		if(isset($input['picture'])){
			if (Input::file('picture')->isValid()) {
				$imagename = $image->getClientOriginalName();
				$newimage=true;
				$destinationPath = 'images/nieuwsitems'; // upload path
				$fileName = $imagename; // renameing image
				$source=Input::file('picture');
				$destination=$destinationPath.'/'.$fileName;

				$quality=100;
				list($width, $height, $type, $attr) = getimagesize($source);

				//echo '<br>width: '.$width;
				//echo '<br>height: '.$height;

				if($width > $height) {
					//make it 800 width and height dependent
					$newwidth = 800;
					$newheight = $height*$newwidth/$width;
				} else {
					$newheight = 150;
					$newwidth = $width*$newheight/$height;
				}
				$off_x = $off_y = 0;

				//echo '<br>newwidth: '.$newwidth;
				//echo '<br>newheight: '.$newheight;
				//exit();

				$thumb_p    = imagecreatetruecolor($newwidth, $newheight);

				$extension  = Input::file('picture')->getClientOriginalExtension();
				$extension=strtolower($extension);

				if($extension == "gif" or $extension == "png" or $extension == "jpg"){

					imagecolortransparent($thumb_p, imagecolorallocatealpha($thumb_p, 0, 0, 0, 127));
					imagealphablending($thumb_p, false);
					imagesavealpha($thumb_p, true);
				}

				if ($extension == 'jpg' || $extension == 'jpeg')
					$thumb = imagecreatefromjpeg($source);
				if ($extension == 'gif')
					$thumb = imagecreatefromgif($source);
				if ($extension == 'png')
					$thumb = imagecreatefrompng($source);

				$bg = imagecolorallocate ( $thumb_p, 255, 255, 255 );
				imagefill ($thumb_p, 0, 0, $bg);

				imagecopyresampled($thumb_p, $thumb, 0, 0, $off_y, $off_x, $newwidth, $newheight, $width, $height);
				if ($extension == 'jpg' || $extension == 'jpeg')
					@imagejpeg($thumb_p,$destination,$quality);
				if ($extension == 'gif')
					@imagegif($thumb_p,$destination,$quality);
				if ($extension == 'png')
					@imagepng($thumb_p,$destination,9);

				imagedestroy($thumb);
				imagedestroy($thumb_p);
			}
		}

		// store the newsitem
		$item = NewsItems::find($id);
		$item->title = $input['title'];
		$item->intro = $input['intro'];
		$item->body = $input['body'];
		if($imagename <> '') {
			$item->picture = 'images/nieuwsitems/' . $imagename;
		}
		$item->start = date_format(date_create_from_format('d/m/Y', $input['startdate']), 'Y-m-d') . ' ' . $input['starttime'];
		if($input['enddate'] == '00/00/0000'){
			$item->end = '0000-00-00 00:00:00';
		}else {
			$item->end = date_format(date_create_from_format('d/m/Y', $input['enddate']), 'Y-m-d') . ' ' . $input['endtime'];
		}

		$item->save();

		return redirect('admin/nieuwsbeheer');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
