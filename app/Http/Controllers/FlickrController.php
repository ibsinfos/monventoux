<?php namespace App\Http\Controllers;

use App\Models\FlickrSet;
use Illuminate\Routing\Controller as BaseController;


class FlickrController extends BaseController
{

    use ControllerUtils;

    private $apiKey = '';
    private $userId = '';

    private $urlRest = "https://api.flickr.com/services/rest/?";

    private $format = "json";

    public function __construct()
    {
        $this->apiKey = config('services.flickr.key');
        $this->userId = config('services.flickr.userid');
    }

    public function getSets()
    {
        $data = [];
        $data['sets'] = FlickrSet::all();
        $data['bodyclass'] = 'flickr';
        $data['title'] = 'Eventfoto\'s';
        $data['event'] = $this->_getEventData();
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();

        return view('flickr.sets', $data);
    }

    public function getSet($set)
    {
        $setData = $this->callMethod('flickr.photosets.getPhotos', [
            'photoset_id' => $set,
            'user_id' => $this->userId,
            'privacy_filter' => 1,
            'extras' => 'url_s'
        ]);

        $data = [];
        $data['set'] = $set;
        $data['bodyclass'] = 'flickr';
        $data['title'] = 'Eventfoto\'s';
        $data['subtitle'] = $setData['photoset']['title'];
        $data['event'] = $this->_getEventData();
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['user'] = $this->userId;
        $data['photos'] = $setData['photoset']['photo'];

        return view('flickr.set', $data);
    }

    private function callMethod($method, array $params)
    {
        $params['method'] = $method;
        $params['api_key'] = $this->apiKey;
        $params['nojsoncallback'] = 1;
        $params['format'] = $this->format;
        $encoded_params = array();
        foreach ($params as $k => $v) {
            $encoded_params[] = urlencode($k) . '=' . urlencode($v);
        }

        $url = $this->urlRest . implode('&', $encoded_params);
        $rsp = file_get_contents($url);
        $rsp_obj = json_decode($rsp, 1);
        return $rsp_obj;
    }

}
