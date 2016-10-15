<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\NewsItems;
use App\Http\Controllers\Controller;
use App\Models\Quote;
use View;
use Input;
use Illuminate\Database\Query\Builder;

use Request;

class ImageFactory
{
	public  function MakeThumb($thumb_target = '', $width = 160,$height = 160,$SetFileName = false, $quality = 100)
	{
		$thumb_img  =   imagecreatefromjpeg($thumb_target);

		// size from
		list($w, $h) = getimagesize($thumb_target);

		if($w > $h) {
			$new_height =   $height;
			$new_width  =   floor($w * ($new_height / $h));
			$crop_x     =   ceil(($w - $h) / 2);
			$crop_y     =   0;
		}
		else {
			$new_width  =   $width;
			$new_height =   floor( $h * ( $new_width / $w ));
			$crop_x     =   0;
			$crop_y     =   ceil(($h - $w) / 2);
		}

		// I think this is where you are mainly going wrong
		$tmp_img = imagecreatetruecolor($width,$height);

		imagecopyresampled($tmp_img, $thumb_img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);

		if($SetFileName == false) {
			header('Content-Type: image/jpeg');
			imagejpeg($tmp_img);
		}
		else
			imagejpeg($tmp_img,$SetFileName,$quality);

		imagedestroy($tmp_img);
	}
}


class QuoteController extends Controller {
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

		$data['quotes'] = Quote::all(array('*'));

		return View::make('admin.quote.index',$data);
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

		return View::make('admin.quote.create', $data);
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
		//dd($image);
		$imagename = $image->getClientOriginalName();

		//upload file
		if(isset($input['picture'])){
			if (Input::file('picture')->isValid()) {
				$destinationPath = 'images/quotes'; // upload path
				$fileName = $imagename; // renameing image
				$source=Input::file('picture');
				$destination=$destinationPath.'/'.$fileName;

				// Initiate class
				$ImageMaker =   new ImageFactory();

				// source image from form
				$thumb_target   =   $source;

				// target square image
				$ImageMaker->MakeThumb($thumb_target,160,160,$destination);

			}
		}

		// store the quote
		$quote = new Quote();
		$quote->name = $input['name'];
		$quote->txt = $input['txt'];
		if($imagename <> '') {
			$quote->img = 'images/quotes/' . $imagename;
		}

		$quote->save();
		
		return redirect('admin/quotebeheer');
		
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

		$data['quote'] = Quote::findOrFail($id);

		return View::make('admin.quote.show',$data);

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

		$data['quote'] = Quote::findOrFail($id);

		return View::make('admin.quote.edit',$data);

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
		$imagename = $image->getClientOriginalName();

		//upload file
		if(isset($input['picture'])){
			if (Input::file('picture')->isValid()) {
				$destinationPath = 'images/quotes'; // upload path
				$fileName = $imagename; // renameing image
				$source=Input::file('picture');
				$destination=$destinationPath.'/'.$fileName;

				// Initiate class
				$ImageMaker =   new ImageFactory();

				// source image from form
				$thumb_target   =   $source;

				// target square image
				$ImageMaker->MakeThumb($thumb_target,160,160,$destination);

			}
		}

		// store the newsitem
		$quote = Quote::find($id);
		$quote->name = $input['name'];
		$quote->txt = $input['txt'];
		if($imagename <> '') {
			$quote->img = 'images/quotes/' . $imagename;
		}

		$quote->save();

		return redirect('admin/quotebeheer');

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
