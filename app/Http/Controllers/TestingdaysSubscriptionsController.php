<?php

namespace App\Http\Controllers;

use App\Models\TestingdaysSubscription;
use App\Models\User;
use Input;
use Redirect;
use Validator;
use Auth;
use View;
use Hash;
use Mail;
use DB;
use Session;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestingdaysSubscriptionsController extends Controller
{
    use ControllerUtils;

    public function showTestingdaysForm(){
        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();
        $data['user'] = Auth::user();

        return View::make('page.testingdays.form',$data);
    }

    public function postTestingdaysForm(){

        // get all inputs
        $inputs = Input::all();

        // set rules
        $rules['block'] = ['required'];
        $rules['product'] = ['required'];

        // create validator
        $validator = Validator::make(
            $inputs,
            $rules
        );

        // validate
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {
            $user = Auth::user();
            // save data
            $testingdaysSubscription = new TestingdaysSubscription();
            $testingdaysSubscription->sadn_id = $user->sadn_id;
            $testingdaysSubscription->block = $inputs['block'];
            $testingdaysSubscription->product = $inputs['product'];
            $testingdaysSubscription->confirmed = 0;
            $testingdaysSubscription->save();

            $products['P1'] = 'Sportmedische keuring (€ 60,00)';
            $products['P2'] = 'Inspanningstest en lactaatmeting (€ 140,00)';
            $products['P3'] = 'Sportmedische keuring + inspanningstest en lactaatmeting (€ 155,00)';
            $blocks['T1'] = 'Tongerlo op woensdag 20 januari 2016 tussen 18.00 en 22.00';
            $blocks['T2'] = 'Tongerlo op donderdag 21 januari 2016 tussen 09.00 en 12.00';
            $blocks['T3'] = 'Tongerlo op donderdag 21 januari 2016 tussen 13.00 en 17.00';
            $blocks['W1'] = 'Wuustwezel op vrijdag 19 februari 2016 tussen 18.00 en 22.00';
            $blocks['W3'] = 'Wuustwezel op zaterdag 20 februari 2016 tussen 09.00 en 12.00';
            $blocks['W4'] = 'Wuustwezel op zaterdag 20 februari 2016 tussen 13.00 en 17.00';
            $blocks['W5'] = 'Wuustwezel op vrijdag 26 februari 2016 tussen 18.00 en 22.00';
            $blocks['W6'] = 'Wuustwezel op zaterdag 27 februari 2016 tussen 09.00 en 12.00';
            $blocks['W7'] = 'Wuustwezel op zaterdag 27 februari 2016 tussen 13.00 en 17.00';

            $data['user'] = $user->voornaam.' '.$user->naam;
            $data['block'] = $blocks[$inputs['block']];
            $data['product'] = $products[$inputs['product']];
            // send confirmation mail
            Mail::send('emails.testingdaysSubscriptions.confirmation', $data, function ($message) use ($testingdaysSubscription) {
                $user = Auth::user();
                $message->to($user->email, $user->first_name . ' ' . $user->name)
                    ->subject('Aanvraag testdag')
                    //->cc( env('MAIL_SENDER_ADDRESS','info@monventoux.be'), env('MAIL_SENDER_ADDRESS','Mon Ventoux'))
                ;
            });

            return Redirect::to(url('/p/testdagen'))
                ->withStatus('Uw aanvraag werd goed genoteerd. U ontvangt weldra een e-mail ter bevestiging.');
        }
    }

}
