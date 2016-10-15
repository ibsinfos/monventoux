<?php namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;


class APIController extends BaseController
{

    public function postNewsletter(Request $request)
    {
        $email = $request->get('email');
        $find = Newsletter::where('email', '=', $email)->first();

        if (empty($email)) {
            $data = [
                'success' => false,
                'message' => 'Vul uw e-mailadres in.',
            ];
            return response()->json($data);
        }
        if (isset($find)) {
            $data = [
                'success' => false,
                'message' => 'U ontvangt de nieuwsbrief al op "'.$email.'".',
            ];
            return response()->json($data);
        }

        $newsletter = new Newsletter();
        $newsletter->email = $email;
        $newsletter->save();

        $email_template = ["emails.newsletter.html", "emails.newsletter.txt"];

        Mail::send($email_template, [], function ($message) use ($email) {
            $message->from('noreply@monventoux.be', 'Mon Ventoux');
            $message->to($email)->subject('Bevestiging inschrijving voor Mon Ventoux nieuwsbrief');
        });

        $data = [
            'success' => true,
            'message' => 'Proficiat. We hebben jouw inschrijving voor de nieuwsbrief goed ontvangen.',
        ];
        return response()->json($data);

    }
}
