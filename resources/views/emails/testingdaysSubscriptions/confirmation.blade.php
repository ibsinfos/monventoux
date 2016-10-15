@extends('emails/layout')

@section('content')
    Beste {{ $user }},<br><br>

    Wij hebben jouw aanvraag voor de {{$product}} in {{$block}} goed ontvangen. Binnenkort ontvang je een e-mail met verdere info.<br><br><br>

    Bedankt en tot binnenkort! <br><br>

    Met vriendelijke groeten,<br>

    Tinne Lauvrys

@stop