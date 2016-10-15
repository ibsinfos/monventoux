<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NavItems;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        $this->redirectTo = '/';
    }


    // overwrite functions in Illuminate\Foundation\Auth\ResetsPasswords for login by username in stead of email

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postUsername(Request $request)
    {
        $this->validate($request, ['username' => 'required']);

        $response = Password::sendResetLink($request->only('username'), function ($m) {
            $m->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['username' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $credentials = $request->only(
            'username', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath());

            default:
                return redirect()->back()
                    ->withInput($request->only('username'))
                    ->withErrors(['username' => trans($response)]);
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Wijzigen van wachtwoord';
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.reset', $data)->with('token', $token);
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function getEmail()
    {

        $data['bodyclass'] = 'auth';
        $data['navigation'] = $this->_getMenuItems();
        $data['footernavigation'] = $this->_getFooterMenuItems();
        $data['event'] = $this->_getEventData();

        return view('auth.password', $data);
    }

    private function _getEventData($path = null)
    {
        if (isset($path)) {
            $ventourist = $path == 'ventourist';
            $lacannibalette = $path == 'lacannibalette';
            $lacannibale = $path == 'lacannibale';
        } else {
            $ventourist = false;
            $lacannibalette = false;
            $lacannibale = false;
        }
        $event = [];
        $event['title'] = '&Eacute;&eacute;n mythische col - Drie hero&iuml;sche uitdagingen';
        $event['subtitle'] = 'Schrijf je in vanaf 17 oktober';
        $event['challenges'] = [];
        $event['challenges'][] = [
            'title' => 'Ventourist',
            'color' => 'purple',
            'distance' => '1 col - 1912m - 21, 22 of 26 km',
            'url' => url('programma/ventourist'),
            'class' => ($ventourist ? 'active' : '')
        ];
        $event['challenges'][] = [
            'title' => 'la Cannibalette',
            'color' => 'gold',
            'distance' => '4 cols - 131km - 3525 hoogtemeters',
            'url' => url('programma/lacannibalette'),
            'class' => $lacannibalette ? 'active' : ''
        ];
        $event['challenges'][] = [
            'title' => 'la Cannibale',
            'color' => 'red',
            'distance' => '6 cols - 173km - 4529 hoogtemeters',
            'url' => url('programma/lacannibale'),
            'class' => $lacannibale ? 'active' : ''
        ];
        return $event;
    }

    private function _getMenuItems()
    {
        $navitems = NavItems::orderBy('order')->get();
        $menuitems = [];

        foreach ($navitems as $navitem) {
            if ($navitem->page->active == 1) {

                $menuitems[] = [
                    'label' => $navitem->page->menulabel,
                    'url' => url($navitem->page->template->name . '/' . $navitem->page->path)
                ];
            }
        }

        return $menuitems;
    }

    private function _getFooterMenuItems()
    {
        $navitems = NavItems::orderBy('order')->get();
        $count = ceil((3 + count($navitems)) / 2);

        $menuitems = [];
        $menugroups = [];
        $index = 1;

        $menuitems[] = [
            'label' => 'Home',
            'url' => url('/')
        ];
//
        foreach ($navitems as $navitem) {
            if ($index == $count) {
                $menugroups[] = $menuitems;
                $index = 0;
                $menuitems = [];
            }
            if ($navitem->page->active == 1) {
                $menuitems[] = [
                    'label' => $navitem->page->menulabel,
                    'url' => url($navitem->page->template->name . '/' . $navitem->page->path)
                ];
                $index++;
            }
        }

        $menuitems[] = [
            'label' => 'Inloggen',
            'url' => url('/login')
        ];
        $menuitems[] = [
            'label' => 'Inschrijven',
            'url' => url('/inschrijven')
        ];

        $menugroups[] = $menuitems;
        return $menugroups;
    }

}
