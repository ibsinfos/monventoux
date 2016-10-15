<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Input;
use Mail;
use Redirect;
use Session;
use Validator;
use View;

class UserController extends Controller
{
    use ControllerUtils;

    protected function _getPrices(){
        return array('cannibale'=>130,
                    'cannibalette'=>130,
                    'tomsimpson'=>170,
                    'ventourist'=>105);
    }

    public function getRegister()
    {

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        // logout if user is logged in and not an admin
        if(Auth::check() && !Auth::User()->bedrijf == 'Sporta Admin'){
            Auth::logout();
        }

        $data['soorten'][''] = 'Kies een type';
        // closed when no admin
        if(Auth::check() && Auth::User()->bedrijf == 'Sporta Admin'){
            $data['soorten']['cannibale'] = 'La Cannibale (€ 125,00)';
            $data['soorten']['cannibalette'] = 'La Cannibalette (€ 125,00)';  
            $data['soorten']['tomsimpson'] = 'Memorial Tom Simpson (€ 170,00)';
            $data['soorten']['ventourist'] = 'Ventourist (€ 105,00)';
        }


        $data['landen'] = ['BE' => 'België', 'NL' => 'Nederland', 'NN' => 'Ander land'];
        $data['nationaliteiten'] = $data['landen'];
        $data['geslachten'] = ['' => 'Kies geslacht', 'man' => 'Man', 'vrouw' => 'Vrouw'];
        $data['maten'] = ['' => 'Kies maat', 'XS' => 'Extra small', 'S' => 'Small', 'M' => 'Medium', 'L' => 'Large', 'XL' => 'Extra Large', 'XXl' => 'Extra extra Large'];
        $data['fietsfrequentie'] = ['' => 'Kies',
            '0' => 'Ik fiets niet',
            '1 tot 2' => 'Ik fiets 1 tot 2 keer per maand',
            '3 tot 4' => 'Ik fiets 3 tot 4 keer per maand',
            '5 tot 8' => 'Ik fiets 5 tot 8 keer per maand',
            '9 of meer' => 'Ik fiets 9 of meer keer per maand'];
        return View::make('page.user.register', $data);
    }

    public function postRegister()
    {

        $inputs = Input::all();

        $validationRules['username'] = ['required', 'unique:mv2016_deelnemers,username'];
        $validationRules['password'] = ['required', 'min:6'];
        $validationRules['password_confirmation'] = ['required', 'min:6', 'same:password'];
        $validationRules['email'] = ['required', 'email'];
        $validationRules['geboortedatum'] = ['required', 'date_format:d/m/Y','before:now','after:-120 years'];
        $validationRules['voornaam'] = ['required'];
        $validationRules['naam'] = ['required'];
        $validationRules['straatennummer'] = ['required'];
        $validationRules['postcode'] = ['required'];
        $validationRules['woonplaats'] = ['required'];
        $validationRules['land'] = ['required'];
        $validationRules['fietsfrequentie'] = ['required'];
        $validationRules['nationaliteit'] = ['required'];
        $validationRules['rijksregisternummer'] = ['required_if:nationaliteit,BE','regex:^[0-9]{11}$^'];
        $validationRules['sofinummer'] = ['required_if:nationaliteit,NL','regex:^[0-9]{8,9}$^'];
        $validationRules['tshirtmaat'] = ['required'];
        $validationRules['geslacht'] = ['required', 'in:man,vrouw'];
        $validationRules['cmlidnummer'] = ['required_if:cmlid,1'];
        $validationRules['algemenevoorwaarden'] = ['required'];
        $validationRules['gedragscode'] = ['required'];
        $validationRules['attest'] = ['required'];

        // closed when no admin
        if(Auth::check() && Auth::User()->bedrijf == 'Sporta Admin'){
            $options[] = 'cannibale';
            $options[] = 'cannibalette'; 
            $options[] = 'ventourist';
            $options[] = 'tomsimpson';
        }
        $validationRules['soort'] = ['required', 'in:'. implode(',',$options)];

        if (Input::get('inschrijving') == 'company') {
            return Redirect::back()->withErrors(['Gelieve contact op te nemen met Sporta voor een inschrijving van een grote groep.'])->withInput();
        }

        $validator = Validator::make(
            $inputs,
            $validationRules
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {
            $user = new User();
            $user->formule = $inputs['soort'];
            $user->username = $inputs['username'];
            $user->password = Hash::make($inputs['password']);
            $user->email = $inputs['email'];
            $user->voornaam = $inputs['voornaam'];
            $user->naam = $inputs['naam'];
            $user->straatennummer = $inputs['straatennummer'];
            $user->postcode = $inputs['postcode'];
            $user->woonplaats = $inputs['woonplaats'];
            $user->gsm = $inputs['gsm'];
            $user->land = $inputs['land'];
            $user->geboortedatum = date_create_from_format('d/m/Y', $inputs['geboortedatum'] );
            $user->nationaliteit = $inputs['nationaliteit'];
            $user->niveau = $inputs['fietsfrequentie'];
            $user->geslacht = $inputs['geslacht'];
            $user->tshirtmaat = $inputs['tshirtmaat'];
            $user->land = $inputs['land'];
            $user->dossierbeheerder = 1;
            $user->cmlid = ( isset($inputs['cmlid']) ) ? 'ja' : 'nee';
            $user->cmlidnummer = $inputs['cmlidnummer'];
            $user->dossierid = (isset($inputs['dossierid'])) ? $inputs['dossierid'] : self::createNewDossierid(substr($user->voornaam, 0, 1) . substr($user->naam, 0, 1));
            $user->annulatieverzekering_deelname = (isset($inputs['annulatieverzekering']))? 5 : 0;

            if($user->nationaliteit == 'BE'){
                $user->rijksregisternummer = $inputs['rijksregisternummer'];
            }elseif($user->nationaliteit == 'NL'){
                $user->sofinummer = $inputs['sofinummer'];
            }

            if($user->cmlid == 'ja'){
                $discountCM = 5;
            } else{
                $discountCM = 0;
            }

            $user->save();

            // !!!! mail is also being send in hashAndMail function
            // make sure imported data is correct in both mails
            $prices = self::_getPrices();
            $data['user'] = $user;
            $data['passwordUnhashed'] = $inputs['password'];
            $data['priceFormule'] = $prices[ $user->formule ];
            $data['discountCM'] = $discountCM;
            $data['totalPrice'] = $prices[ $user->formule ] - $discountCM + $user->annulatieverzekering_deelname;

            $data['receiver'] = 'user';
            Mail::send('emails.welcome', $data, function ($message) use ($user) {
                $message->to($user->email, $user->voornaam . ' ' . $user->naam)->subject('Welkom bij Mon Ventoux');
            });

            $data['receiver'] = 'sporta';
            Mail::send('emails.welcome', $data, function ($message) use ($user) {
                $message->to( env('MAIL_SENDER_ADDRESS','info@monventoux.be') , $user->voornaam . ' ' . $user->naam)->subject('Welkom bij Mon Ventoux');
            });

            return Redirect::to('bevestiging')
                ->withNewuser($user);
        }
    }

    public function confirmation(){

        if(Session::get('newuser')){
            $data['bodyclass'] = 'auth';
            $data['navigation'] = $this->_getMenuItems();
            $data['footernavigation'] = $this->_getFooterMenuItems();
            $data['event'] = $this->_getEventData();

            $data['user'] = Session::get('newuser');
            
            return View::make('page.user.confirmation',$data);
        }
        else{
            return Redirect::to('');
        }

    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('')->withStatus('U bent uitgelogd.');
    }

    public function getLogin()
    {
        $data = [];
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return view('page.user.login', $data);
    }

    public function postLogin()
    {
        $inputs = Input::all();

        $username = $inputs['username'];
        $password = $inputs['password'];
        $validationRules = array('password' => ['min:6', 'required'],
            'username' => ['required', 'exists:mv2016_deelnemers,username']);

        $validator = validator::make(
            Input::all(),
            $validationRules
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {
            if (Auth::attempt(['username' => $username, 'password' => $password])) {
                if(Session::has('url.intended')){
                    return Redirect::intended();
                } else {
                    return Redirect::to('home');
                    // ->withStatus('U bent ingelogd');
                }
            } else {
                return Redirect::back()->withErrors(['Wachtwoord is niet correct'])->withInput();
            }
        }
    }

    public function index()
    {
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        $data['landen'] = ['BE' => 'België', 'NL' => 'Nederland', 'NN' => 'Ander land'];
        return View::make('page.user.index',$data);
    }

    public function editUser()
    {

        $inputs = Input::all();

        $validationRules = array(
            'straatennummer' => ['required'],
            'postcode' => ['required'],
            'woonplaats' => ['required'],
            'land' => ['required'],
            'email' => ['required','email']
            );

        $validator = validator::make(
            $inputs,
            $validationRules
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {
            $user = User::find(Auth::User()->sadn_id);
            $user->straatennummer = $inputs['straatennummer'];
            $user->postcode = $inputs['postcode'];
            $user->woonplaats = $inputs['woonplaats'];
            $user->land = $inputs['land'];
            $user->gsm = $inputs['gsm'];
            $user->email = $inputs['email'];
            $user->save();

            return Redirect::back()->withStatus('Gegevens opgeslagen!');
        }

        return View::make('page.user.index');
    }

    public function showImportedMembers(){

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        $data['users'] = User::where('bedrijf','<>','')
                            ->whereNotNull('bedrijf')
                            ->where('password','not like','$2y$10$%')
                            ->where(DB::raw('length(password)'),'<>', 60)
                            ->get();

        return View::make('admin.mails',$data);
    }

    public function hashAndMail(){

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        $inputs = Input::all();

        $validator = validator::make(
            $inputs,
            array( 'sendMail' => ['array'] )
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {

            $message = 'De mails zijn verzonden en de paswoorden zijn aangemaakt voor onderstaande personen.<ul>';
            foreach($inputs['sendMail'] as $id){
                // !!!! mail is also being send in postRegister function
                // make sure imported data is correct in both mails

                $user = User::find($id);

                $data['user'] = $user;

                if($user->cmlid == 'ja'){
                    $discountCM = 5;
                } else{
                    $discountCM = 0;
                }

                $prices = self::_getPrices();
                $data['passwordUnhashed'] = $data['user']->password;
                $data['bulk'] = true;

                $data['priceFormule'] = $prices[ $user->formule ];
                $data['discountCM'] = $discountCM;
                $data['totalPrice'] = $prices[ $user->formule ] - $discountCM + $user->annulatieverzekering_deelname;

                $data['receiver'] = 'user';
                Mail::queue('emails.welcome', $data, function($message) use ($user) {
                    $message->to($user->email, $user->voornaam . ' ' . $user->naam)->subject('Welkom bij Mon Ventoux');
                });

                $data['receiver'] = 'sporta';
                Mail::queue('emails.welcome', $data, function($message) use ($user) {
                    $message->to( env('MAIL_SENDER_ADDRESS','info@monventoux.be') , $user->voornaam . ' ' . $user->naam)->subject('Welkom bij Mon Ventoux');
                });

                $user->password = Hash::make($user->password);
                $user->save();

                $message .= '<li>' . $user->bedrijf . ' - ' . $user->voornaam . ' ' . $user->naam . '</li>';
            }
            $message.='</ul>';

            return Redirect::back()->withStatus($message);
        }

    }

    public function showCertificate(){
        $data['user'] = User::find(Auth::user()->sadn_id);
        return View::make('old.medischattest',$data);
    }

    // public function showDossier()
    // {

    //     $data['users'] = User::where('dossierid', '=', Auth::user()->dossierid)
    //         ->orderBy('naam')
    //         ->orderBy('voornaam')
    //         ->get();
    //     $data['dossierbeheerder'] = User::where('dossierid', '=', Auth::user()->dossierid)
    //         ->where('dossierbeheerder', '=', '1')
    //         ->first();

    //     return View::make('page.user.dossier', $data);
    // }


    private function createNewDossierid($initials)
    {
        $user = User::where(DB::raw('substr(dossierid,1,2)'), '=', $initials)
            ->select('dossierid', 'sadn_id')
            ->orderBy(DB::raw(" cast(substr(dossierid,3) as UNSIGNED )"), 'desc')
            ->take(1)->get();

        if (count($user) > 0) {
            $dossierid = $initials . (substr($user[0]->dossierid, 2) + 1);
        } else {
            $dossierid = $initials . 1;
        }
        return strtoupper($dossierid);
    }

    public function showProgram()
    {
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return View::make('page.user.program', $data);
    }

    public function home()
    {
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return View::make('page.user.home', $data);
    }

    public function touristicGuide()
    {
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return View::make('page.user.touristicGuide', $data);
    }

    public function downloadCorner()
    {
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        $files = scandir ( '../public/download/downloadcorner' );
        $files = array_diff($files, array('.', '..')); //remove de . and .. of the dir

        $data['files'] = $files;

        return View::make('page.user.downloadCorner', $data);
    }
}
