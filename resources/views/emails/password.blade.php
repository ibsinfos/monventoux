@extends('emails/layout')

@section('content')

klik hier om je wachtwoord te wijzigen:<br>
{{ url('password/reset/'.$token) }}

@stop