@extends('emails/layout')

@section('content')

Beste {{ $volunteer->first_name }},<br><br>

Alvast bedankt om je te engageren als vrijwilliger voor Mon Ventoux 2016!<br><br>

Hierbij noteer ik alvast jouw gegevens. In het voorjaar van 2016 (rond februari – maart) ontvang je van mij een e-mail waarin we al een tipje van de sluier van het vrijwilligerspakket vrijgeven. <br><br>

Onderstaande persoonlijke gegevens werden genoteerd. Mag ik vragen deze goed de controleren. Indien onderstaande info niet correct is, gelieve deze e-mail terug te zenden naar info@monventoux.be, met de juiste gegevens. <br><br>

<b>Naam:</b> {{ $volunteer->first_name . ' ' . $volunteer->name }} <br>
<b>Email:</b> {{ $volunteer->email }} <br>
<b>Tel.:</b> {{ $volunteer->phone }} <br>
<b>Gsm:</b> {{ $volunteer->mobile }} <br>
<b>Link met deelnemer:</b> {{ $volunteer->linked_participant }} <br>
<b>Verblijfplaats in Frankrijk:</b> {!! nl2br($volunteer->whereabouts) !!} <br><br>

Bedankt en tot binnenkort! <br><br>

Met vriendelijke groeten. <br><br>

Tinne

@stop