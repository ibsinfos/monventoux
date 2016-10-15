<?php namespace App\Http\Controllers;

use App\Models\FlickrSet;
use Illuminate\Routing\Controller as BaseController;


class LivestreamController extends BaseController
{

    use ControllerUtils;

    public function getStream($location)
    {
        switch ($location){
            case 'top':
                $url = 'http://www.cimternet.com/montventoux2016/sommet.htm';
                $msg = 'Het event is definitief afgelast.';
                break;
            case 'village':
                $url = 'http://www.cimternet.com/montventoux2016/depart.htm';
                $msg = 'Het event is definitief afgelast.';
                break;
        }

        $data = [];
        $data['urlstream'] = $url;
        $data['msg'] = $msg;
        $data['location'] = $location;
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['bodyclass'] = 'page';
        $data['event'] = $this->_getEventData();
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();

        return view('page.livestream.index', $data);
    }

}
