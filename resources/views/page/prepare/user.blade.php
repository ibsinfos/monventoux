@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-pagehead')
    @include('partials.partial-menu')

    <div class="page-sections">
        <header class="page-header">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    <h1 class="color-darkblue flamenco text-center">Bevestigen</h1>
                    <h4 class="color-darkblue lato text-italic text-center"></h4>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    <h5>U bent {{$user->voornaam}} {{substr($user->naam,0,1)}}. ?</h5>

                    <a href="{{url('/voorbereiden/ritten/inschrijven/'.$route->id)}}"
                       class="columns small-12 medium-6 large-4 button small rounded">Nee, ga terug</a>

                    <div class="columns small-12 medium-6 large-8">
                        {!! Form::open() !!}

                        {{--{{dd($user->geboortedatum)}}--}}
                        {{--{{die()}}--}}
                        {!!Form::hidden('_token',csrf_token())!!}
                        {!!Form::hidden('route_id',$route->id)!!}
                        {!!Form::hidden('user',$user)!!}
                        {!!Form::hidden('firstname',$user->voornaam)!!}
                        {!!Form::hidden('lastname',$user->naam)!!}
                        {!!Form::hidden('email',$user->email)!!}
                        {!!Form::hidden('street',$user->straatennummer)!!}
                        {!!Form::hidden('postalcode',$user->postcode)!!}
                        {!!Form::hidden('city',$user->woonplaats)!!}
                        {!!Form::hidden('country','')!!}
                        {!!Form::hidden('dob_formatted',$user->geboortedatum)!!}
                        {!!Form::hidden('gender',$user->geslacht == 'man' ? 'M':'V')!!}
                        {!!Form::hidden('algemenevoorwaarden','1')!!}
                        {!!Form::hidden('gedragscode','1')!!}
                        {!!Form::hidden('phone',$user->tel)!!}
                        {!!Form::hidden('options',$option)!!}
                        {!!Form::hidden('deelnemersnummer',$deelnemersnummer)!!}

                        <button class="small rounded" style="width:100%;display:block;"
                                type="submit">Ja, schrijf me in voor {{$route->name}}</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop