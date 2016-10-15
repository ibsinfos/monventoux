<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Input;
use Validator;
use Mail;

class VolunteerController extends Controller
{
    use ControllerUtils;

    public function showForm(){

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return View::make('page.volunteers.form',$data);
    }

    public function postForm(){

        // get all inputs
    	$inputs = Input::all();

        // set rules
        $rules['name'] = ['required'];
        $rules['first_name'] = ['required'];
        $rules['phone'] = ['required_without:mobile'];
        $rules['mobile'] = ['required_without:phone'];
        $rules['email'] = ['required','email'];
        $rules['whereabouts'] = ['required'];

        // create validator
        $validator = Validator::make(
            $inputs,
            $rules
        );

        // validate
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator->messages())->withInput();
        } else {
            // save data
            $volunteer = new Volunteer();
            $volunteer->name = $inputs['name'];
            $volunteer->first_name = $inputs['first_name'];
            $volunteer->phone = $inputs['phone'];
            $volunteer->mobile = $inputs['mobile'];
            $volunteer->email = $inputs['email'];
            $volunteer->linked_participant = $inputs['linked_participant'];
            $volunteer->whereabouts = $inputs['whereabouts'];
            $volunteer->save();

            $data['volunteer'] = $volunteer;
            // send confirmation mail
            Mail::send('emails.volunteers.confirmation', $data, function ($message) use ($volunteer) {
                $message->to($volunteer->email, $volunteer->first_name . ' ' . $volunteer->name)
                        ->subject('Aanmelding vrijwilliger Mon Ventoux')
                        ->cc( env('MAIL_SENDER_ADDRESS','info@monventoux.be'), env('MAIL_SENDER_ADDRESS','Mon Ventoux') );
            });

            return Redirect::to(url('/p/vrijwilliger'))
                ->withStatus('Uw engagement werd goed genoteerd. U ontvangt weldra een e-mail met info.');
        }      
    }

}
