<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photocontest;
use View;
use Input;
use Auth;
use Request;

class photocontestController extends Controller {
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

        $data['photos'] = array();
        $pagephotos = Photocontest::paginate(10);
        $data['photos'] = $pagephotos;

        return View::make('page.photocontest.index',$data);
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
        if(Auth::check()){
            $data['name'] = Auth::user()->naam;
            $data['surname'] = Auth::user()->voornaam;
            $data['participant'] = Auth::user()->deelnemersnummerE;
            $data['email'] = Auth::user()->email;
        }else{
            $data['name'] = '';
            $data['surname'] = '';
            $data['participant'] = '';
            $data['email'] = '';
        }



        return View::make('page.photocontest.create', $data);
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
                $destinationPath = 'images/fotowedstrijd'; // upload path
                $fileName = date('YmdHis') . '_' . $input['participant']. '_' . $imagename; // renameing image
                $source=Input::file('picture');
                $destination=$destinationPath.'/'.$fileName;

                $quality=100;
                list($width, $height, $type, $attr) = getimagesize($source);

                //echo '<br>width: '.$width;
                //echo '<br>height: '.$height;

                if($width > 1024 || $height > 768) {
                    if ($width > $height) {
                        //make it 1024 width and height dependent
                        $newwidth = 1024;
                        $newheight = $height * $newwidth / $width;
                    } else {
                        $newheight = 768;
                        $newwidth = $width * $newheight / $height;
                    }
                }else{
                    $newwidth = $width;
                    $newheight = $height;
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
                //imagecopyresampled($thumb_p, $thumb, 0, 0, $off_y, $off_x, $width, $height, $width, $height);
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

// store the data
        $item = new Photocontest();
        $item->name = $input['name'];
        $item->surname = $input['surname'];
        $item->email = $input['email'];
        $item->participant = $input['participant'];
        if($imagename <> '') {
            $item->picture = 'images/fotowedstrijd/' . $imagename;
        }
        $item->description = $input['description'];

        $item->save();

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();
        $data['contester'] = $item;

        return View::make('page.photocontest.thanks', $data);

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
//
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
