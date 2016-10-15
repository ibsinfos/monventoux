@extends('emails/layout')

@section('content')

    @if($role == 'sporta')
        <h2>NAW gegevens</h2>
        <ul>
            @if(!isset($subscription->deelnemersnummer) || is_null($subscription->deelnemersnummer) || empty($subscription->deelnemersnummer))
                <li><strong>Het betreft een Mon Ventouw gebruiker</strong></li>
                <li><strong>Deelnemersnummer:</strong> {{$subscription->deelnemersnummer}}</li>
                <li><strong>Gebruikers id:</strong> {{$subscription->user_id}}</li>
            @endif
            <li><strong>Voornaam:</strong> {{$subscription->firstname}}</li>
            <li><strong>Achternaam:</strong> {{$subscription->lastname}}</li>
            <li><strong>E-mail:</strong> {{$subscription->email}}</li>
            <li><strong>Adres:</strong> {{$subscription->street}} {{$subscription->number}}</li>
            <li><strong>Postcode + Woonplaats:</strong> {{$subscription->postalcode}}, {{$subscription->city}}</li>
            @if($subscription->country == 'BE')
                <li><strong>Land:</strong> Belgi&uml;</li>
            @elseif($subscription->country == 'NL')
                <li><strong>Land:</strong> Nederland</li>
            @else
                <li><strong>Land:</strong> Onbekend</li>
            @endif
            @if($subscription->gender == 'M')
                <li><strong>Geslacht:</strong> Man</li>
            @else
                <li><strong>Geslacht:</strong> Vrouw</li>
            @endif
            @if(isset($subscription->phone) && !empty($subscription->phone))
                <li><strong>GSM-nummer:</strong> $subscription->phone</li>
            @else
                <li><strong>GSM-nummer:</strong> Onbekend</li>
            @endif
            <li><strong>Geboortedatum:</strong> {{$dob}}</li>
            @if(!isset($deelnemersnummer) || is_null($deelnemersnummer) || empty($deelnemersnummer))
                <li><strong>Te betalen:</strong> &euro;8,-</li>
            @else
                <li><strong>Te betalen:</strong> &euro;0,-</li>
            @endif
        </ul>
    @endif

    @if($role == 'user')
        <p>Beste {{$subscription->firstname}},</p>
        <p>  Bedankt voor je inschrijving.</p>
        <p>Fijn dat je mee komt fietsen in {{$subscription->route->location}}.</p>
        <h2>  Jouw keuze</h2>
        <ul>

            <li><strong>Locatie:</strong> {{$subscription->route->location}}</li>
            <li><strong>Programma:</strong> {{$option->name}}</li>
            @if(!isset($subscription->deelnemersnummer) || is_null($subscription->deelnemersnummer) || empty($subscription->deelnemersnummer))
                <li><strong>Kostprijs:</strong> &euro;8,-</li>
            @else
                <li><strong>Kostprijs:</strong> &euro;0,-</li>
            @endif
        </ul>

        <p>  Meer praktische info over deze trainingsrit? <a
                    href="http://www.monventoux.be/public/voorbereiden/ritten/info/{{$subscription->route->id}}"
                    target="_blank">Klik hier   </a></p>
        <h2>Vragen?</h2>
        <p>Wij zijn er om jou te helpen. <br> E info@monventoux.be <br> T 014 53 95 75</p>
    @endif

@stop

