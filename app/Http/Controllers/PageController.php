<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\FrontPage;
use App\Models\Page;
use App\Models\PagePictureSet;
use App\Models\PrepareRoute;
use App\Models\PrepareRouteOption;
use App\Models\PrepareRouteSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Redirect;

class PageController extends Controller
{
    use ControllerUtils;

    public function getFrontPage()
    {
        $frontpage = FrontPage::where('active','=','1')->first();

        // data array
        $data = [];
        $data['bodyclass'] = 'home';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['title'] = $frontpage->title;
        $data['slogan'] = $frontpage->slogan;
        $data['eventdate'] = $frontpage->subtitle;
        $data['image'] = $frontpage->image;
        $data['event'] = $this->_getEventData();

        $why = [];
        $why['title'] = 'Waarom deelnemen?';
        $why['content'] = 'Ut nisi sem, dignissim et ultricies ac, vehicula at quam. Donec suscipit feugiat lectus nec imperdiet. Nulla a tellus nisl. Cras luctus enim sapien, at porta magna varius eget.';
        $why['url1'] = url('p/overmonventoux');
        $why['url2'] = '#';
        $why['url3'] = url('p/drie-uitdagingen');
        $why['url4'] = url('p/voorbereidingsritten');
        $why['url5'] = url('p/lavintoux');
        $why['url6'] = url('p/goeddoel');
        $data['why'] = $why;

        $data['eventday'] = $this->_getEventDayData();

        $calendar = [];
        $calendar['days'] = $this->_getDaysUntilStart();
        $data['calendar'] = $calendar;
        $data['dates'] = $this->_getCalendarDates();

        $blog = [];
        $blog['image'] = asset('assets/img/blog/inschrijvingsstop.jpg');
        $blog['title'] = 'Stopzetting inschrijvingen';
        $blog['excerpt'] = 'De laatste deelnamebewijzen zijn definitief de deur uit. Inschrijven voor Mon Ventoux 2016 is helaas niet meer mogelijk.';
        $blog['href'] = url('/p/stopzetting');
        $data['blog'] = $blog;

        $data['news'] = $this->_getNewsData();

        $data['quotes'] = $this->_getQuoteData();

        $images = $this->_getHomeMediaData();
        $data['mediadata'] = $this->_getMediaData($images);
        $data['banner'] = $this->_getRandomBanner();


        $data['partners'] = $this->_getPartnerData();

        return view($frontpage->blade_file, $data);
    }

    /**
     * @param $path
     * @return \Illuminate\View\View
     */
    public function getPage($path, $subpath = null)
    {
        if (is_null($subpath)) {
            $page = Page::where('path', '=', $path)
                ->where('template_id', '=', 1)
                ->where('active', '=', 1)
                ->first();
        } else {
            $page = Page::where('path', '=', $subpath)
                ->where('template_id', '=', 1)
                ->where('active', '=', 1)
                ->first();
        }

        if (!isset($page)) {
            return abort(404);
        }

        $pagepictures = [];
        $pictureset = PagePictureSet::where('page_id', '=', $page['id'])->first();
        if (!is_null($pictureset)) {
            $pictures = $pictureset->picturesetpictures()->get()->toArray();
        } else {
            $pictures = [];
        }
        //var_dump($pictures);
        foreach ($pictures as $pic) {
            $picturedata['small'] = asset('/assets/img/' . $pic['small_image_name']);
            $picturedata['alt'] = 'Mon Ventoux 2017';
            $picturedata['large'] = asset('/assets/img/' . $pic['large_image_name']);
            $picturedata['type'] = 'image';
            $pagepictures[] = $picturedata;
        }

        $data = [];
        $data['page'] = $page;
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['bodyclass'] = 'page';
        $data['event'] = $this->_getEventData($path);
        $data['quotes'] = $this->_getQuoteData();
        $images = $this->_getHomeMediaData();
        $data['mediadata'] = $this->_getMediaData($images);
        $data['pagepictures'] = $pagepictures;
        return view('page.page', $data);
    }

    /**
     * @param $program = path of program
     * @param $path = var path
     * @return \Illuminate\View\View
     */
    public function getProgram($program, $path = null)
    {
        $totalpath = $program;
        if (isset($path)) {
            $totalpath = $totalpath . '/' . $path;
        }
        $page = Page::where('path', '=', $totalpath)
            ->where('template_id', '=', 2)
            ->where('active', '=', 1)
            ->first();

        if (!isset($page)) {
            return abort(404);
        }

        $data = [];
        $data['bodyclass'] = 'page program';
        $data['page'] = $page;
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData($program);
        $data['color'] = $this->_getColor($program);
        $data['quotes'] = $this->_getQuoteData();

        $images = $this->_getHomeMediaData();

        if ($program == 'ventourist') {
            $data['parcourspdf'] = asset('/download/pdf/parcours-ventourist.pdf');
            $images = $this->_getVentouristData();
        }
        if ($program == 'lacannibale') {
            $data['parcourspdf'] = asset('/download/pdf/parcours-la-cannibale.pdf');
            $images = $this->_getCannibaleData();
        }
        if ($program == 'lacannibalette') {
            $data['parcourspdf'] = asset('/download/pdf/parcours-la-cannibalette.pdf');
            $images = $this->_getCannibaletteData();
        }
        if ($program == 'tomsimpsonmemorial') {
            $data['parcourspdf'] = asset('/download/pdf/parcours-tom-simpson-memorial.pdf');
            $images = $this->_getTomSimpsonData();
        }


        $data['mediadata'] = $this->_getMediaData($images);
        return view('page.program', $data);
    }

    public function getPreparePage($path, $id = null)
    {
        $page = Page::where('path', '=', $path)
            ->where('template_id', '=', 3)
            ->where('active', '=', 1)
            ->first();

        if (!isset($page)) {
            return abort(404);
        }

        $data = [];
        $data['page'] = $page;
        $data['path'] = '/voorbereiden/' . $path . '/info/';
        $data['subscribepath'] = '/voorbereiden/' . $path . '/inschrijven/';

        if (isset($id)) {
            $route = PrepareRoute::find($id);
        } else {
            return redirect('/voorbereiden/' . $path . '/info/' . $page->routes->first()->id);
        }

        if (!isset($route)) {
            return abort(404);
        }

        $data['route'] = $route;
        $data['navigation'] = $this->_getMenuItems();
        $data['event'] = $this->_getEventData($path);
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['bodyclass'] = 'page prepare';

        return view('page.prepare.route', $data);
    }

    public function getPrepareSubscribe($path, $id = null)
    {
        $page = Page::where('path', '=', $path)
            ->where('template_id', '=', 3)
            ->where('active', '=', 1)
            ->first();

        if (!isset($page)) {
            return abort(404);
        }

        if (isset($id)) {
            $route = PrepareRoute::find($id);
        } else {
            return redirect('/voorbereiden/' . $path . '/info/' . $page->routes->first()->id);
        }

        if (!isset($route) || (intval($route->active_subscription) == 0)) {
            return redirect('/voorbereiden/' . $path . '/info/' . $route->id);
        }

        $user = Auth::user();

        $data['user'] = $user;
        $data['route'] = $route;
        $data['navigation'] = $this->_getMenuItems();
        $data['event'] = $this->_getEventData($path);
        $data['countries'] = ['BE' => 'België', 'NL' => 'Nederland', 'NN' => 'Ander land'];
        $data['genders'] = ['M' => 'Man', 'V' => 'Vrouw'];
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['bodyclass'] = 'page prepare';

        return view('page.prepare.subscribe', $data);
    }

    public function postPrepareSubscribe(Request $request)
    {

        if ($request->get('ismember') == '1') {
            $validationRules = [
                'deelnemersnummer' => ['required', 'exists:mv2016_deelnemers,deelnemersnummerE'],
                'options' => ['required']
            ];
        } else {

            $validationRules = [
                'email' => ['required', 'email'],
                'dob' => ['required_without:dob_formatted', 'date_format:d/m/Y', 'before:now', 'after:-120 years'],
                'dob_formatted' => ['required_without:dob'],
                'firstname' => ['required'],
                'lastname' => ['required'],
                'street' => ['required'],
                'postalcode' => ['required'],
                'city' => ['required'],
                'country' => ['required_without:dob_formatted'],
                'gender' => ['required', 'in:M,V'],
                'options' => ['required'],
                'algemenevoorwaarden' => ['required'],
                'gedragscode' => ['required']
            ];
        }

        $validator = Validator::make(
            $request->all(),
            $validationRules,
            ['options.required' => 'Kies uw gratis optie']
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {


            $data = [];
            $data['navigation'] = $this->_getMenuItems();
            $data['event'] = $this->_getEventData();
            $data['footernavigation'] = $this->_getFooterMenuItems();
            $data['bodyclass'] = 'page prepare';
            $data['route'] = PrepareRoute::find($request->get('route_id'));

            $ismember = $request->get('ismember');
            if ($ismember == '1') {
                $user = User::where('deelnemersnummerE', '=', $request->get('deelnemersnummer'))->first();

                $data['deelnemersnummer'] = $request->get('deelnemersnummer');
                $data['user'] = $user;
                $data['option'] = $request->get('options');

                return view('page.prepare.user', $data);
            } else {

                $subs = new PrepareRouteSubscription();
                if (!is_null($request->get('deelnemersnummer'))) {
                    $user = User::where('deelnemersnummerE', '=', $request->get('deelnemersnummer'))->first();


                    if (!is_null($user)) {
                        $subs->deelnemersnummer = $request->get('deelnemersnummer');
                        $subs->dob = $request->get('dob_formatted');
                        $subs->user_id = $user->sadn_id;
                    }
                }

                if (!is_null($request->get('dob'))) {
                    $subs->dob = date_create($request->get('dob'));
                }

                $subs->gender = $request->get('gender');
                $subs->firstname = $request->get('firstname');
                $subs->route_id = $request->get('route_id');
                $subs->lastname = $request->get('lastname');
                $subs->email = $request->get('email');
                $subs->street = $request->get('street') . ' ' . $request->get('number');
                $subs->postalcode = $request->get('postalcode');
                $subs->city = $request->get('city');
                $subs->country = $request->get('country');

                $subs->phone = $request->get('phone');
                $subs->option_id = $request->get('options');

//                return dd(intval($request->get('options')));
                $subs->save();

                $data['subscription'] = $subs;
                $data['option'] = PrepareRouteOption::find($request->get('options'));
                $data['role'] = 'user';

                Mail::send('emails.routeconfirm', $data, function ($message) use ($subs) {
                    $message->to($subs->email, $subs->firstname . ' ' . $subs->lastname)->replyTo('info@monventoux.be', 'Mon Ventoux')->subject('MV-dag ' . $subs->route->name . ' – bevestiging inschrijving');
                });

//                $data['role'] = 'sporta';
//                Mail::send('emails.routeconfirm', $data, function ($message) use ($subs) {
//                    $message->to(env('MAIL_SENDER_ADDRESS', 'info@monventoux.be'))->replyTo($subs->email, $subs->firstname . ' ' . $subs->lastname)->subject('MV-dag ' . $subs->route->name . ' – bevestiging inschrijving');
//                });

                return view('page.prepare.thanks', $data);
            }
        }
    }

    public function getNews(){
        $newsitems = $this->_getNewsData();
        $data = [];
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();
        $data['newsitems'] = $newsitems;

        //print_r($data);
        return view('page.news.showall', $data);
    }
}


//$subs = new PrepareRouteSubscription();
//$subs->deelnemersnummer = $request->get('deelnemersnummer');
//$subs->user_id = $user->sadn_id;
//$subs->firstname = $user->voornaam;
//$subs->route_id = $request->get('route_id');
//$subs->lastname = $user->naam;
//$subs->email = $user->email;
//$subs->street = $user->straatennummer;
//$subs->number = '';
//$subs->postalcode = $user->postcode;
//$subs->city = $user->woonplaats;
//$subs->country = '';
//$subs->dob = $user->geboortedatum;
//$subs->phone = $user->tel;
//$subs->save();
