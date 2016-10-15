<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;

use App\Models\WebshopOrder;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use View;
use Redirect;
use Input;
use Validator;
use Mail;

class WebshopController extends Controller
{
    use ControllerUtils;

    private $products = [
        [
            'id' => '1',
            'name' => 'Trui korte mouw',
            'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
            'genders' => ['Heren', 'Dames'],
            'prices' => [45, 35],
            'discount' => 10
        ],
        [
            'id' => '2',
            'name' => 'Trui lange mouw',
            'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
            'genders' => ['Unisex'],
            'prices' => [59, 49],
            'discount' => 10
        ],
        [
            'id' => '3',
            'name' => 'Broek',
            'sizes' => ['S', 'M', 'L', 'XL'],
            'genders' => ['Heren', 'Dames'],
            'prices' => [52, 42],
            'discount' => 10
        ],
        [
            'id' => '4',
            'name' => 'Windblock',
            'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
            'genders' => ['Unisex'],
            'prices' => [64, 54],
            'discount' => 10
        ]
    ];

    public function index()
    {

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return View::make('page.webshop.details', $data);
    }

    public function create()
    {
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        $user = Auth::user();
        $data['user'] = $user;
        $data['products'] = $this->products;


        // boolean om member prijs te selecteren of niet.
        // TODO: deze members variabel koppelen aan angular $scope.memberdata
        $data['members'] = false;

        return View::make('page.webshop.form', $data);
    }

    public function store(Request $request)
    {

        $list = $request->get('products');
        $discount = $request->get('discount');
        $subtotal = $request->get('subamount');
        $total = $request->get('amount');
        //$membernumber = $request->get('membernumber');

        $products = [];
        foreach ($list as $item) {

            $decoded = json_decode($item, true);

            $product = [
                'name' => $decoded[0],
                'gender' => $decoded[1],
                'size' => $decoded[2],
                'count' => intval($decoded[3]),
                'price' => intval($decoded[4]),
                'discount' => intval($decoded[5]),
            ];

            $products[] = $product;
        }

        $order = new WebshopOrder();
        $order->products = json_encode($products);
        $order->subtotal = $subtotal;
        $order->total = $total;
        $order->discount = $discount;

        $order->firstname = $request->get('firstname');
        $order->lastname = $request->get('lastname');
        $order->address = $request->get('street') . ' ' . $request->get('number');
        $order->postalcode = $request->get('postalcode');
        $order->city = $request->get('city');
        $order->country = $request->get('country');
        $order->phone = $request->get('phone');
        $order->email = $request->get('emailaddress');

        /*everybody gets discount to get rid of overstock
        if (is_null($membernumber) || empty($membernumber)) {
            $discount = 0;
        }
        */

        //$order->cm_membernr = $membernumber;
        $order->cm_membernr = '';
        $order->send = $request->get('sendcost') == 0 ? 0 : 1;
        $order->location = $request->get('collectlocation') == 'send' ? '' : $request->get('collectlocation');

        $order->save();

        $data = [
            'products' => $products,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'order' => $order
        ];
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();
        if ($request->get('collectlocation') == 'tongerlo') {
            $data['retrieve'] = 'Sporta Centrum Tongerlo';
        } else {
            $data['retrieve'] = 'De Mon Ventoux dag';
        }

        return View::make('page.webshop.thanks', $data);
    }

}
