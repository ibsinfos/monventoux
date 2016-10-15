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
                    <h1 class="color-darkblue flamenco text-center">
                        Fotowedstrijd
                    </h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-36 medium-24 large-18 medium-centered end">
                     <H3>POST JOUW VENTOUX-FOTO & WIN EEN EDDY MERCKX-FIETS</H3>
                    <p>
                        Op 18 juni schrijf jij geschiedenis. En dat mag heel de wereld weten, toch? Daarom posten we jou favoriete Ventoux-foto’s op onze facebookpagina. Meer nog: de ultieme foto krijgt als beloning een Eddy Merckx-fiets ter waarde van 3.000 euro. Zit er nog in onze prijzenpot: 10 canvassen met jouw ingezonden foto. Snap, post, win!
                    </p>
                    <h4>Hoe neem je deel aan onze fotowedstrijd?</h4>
                    <p>
                        <ul>
                        <li>Stap 1: Snap jouw Ventoux-foto (belangrijk: in hoge resolutie v.a. 1 MB)</li>
                        <li>Stap 2: Post jouw foto op facebook, instagram of twitter met #monventoux</li>
                        <li>Stap 3: Upload jouw foto via onderstaand wedstrijdformulier. Vergeet je persoonsgegevens en deelnamenummer niet.</li>
                        <li>Stap 4: Beschrijf kort jouw foto</li>
                        </ul>
                    </p>
                    <h4>Onze prijzen?</h4>
                    <p>
                        <ul>
                        <li><strong>Ultieme foto Mon Ventoux 2016:</strong><br />
                            De hoofdwinnaar gaat aan de haal met een Eddy Merckx fiets Model: Mourenx69/SanRemo t.w.v. €3.000</li>
                        <li><strong>10 meest beklijvende foto’s</strong><br />
                            Krijgen hun ingezonden foto op canvas thuis gestuurd.<br />
                            (voorwaarde = voldoende hoge resolutie)</li>
                        </ul>


                    </p>

        <div class="page-content">
            <div class="row">
                <div class="columns small-36 medium-24 large-18 medium-centered end">

                    @if(Session::has('status'))
                        <div>
                            <p>{!! Session::get('status') !!}</p>
                        </div>
                    @endif

                    {!! Form::open(['url' => '/fotowedstrijd/store', 'files' => true]) !!}

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('name', 'Naam: ') !!}
                        {!! Form::text('name', $name, ['class' => 'form-control', 'maxlength' => '255']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('surname', 'Voornaam: ') !!}
                        {!! Form::text('surname', $surname, ['class' => 'form-control', 'maxlength' => '255']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('email', 'E-mail: ') !!}
                        {!! Form::text('email', $email, ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('participant', 'Deelnemersnummer : ') !!}
                        {!! Form::text('participant', $participant, ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('picture', 'Afbeelding: ') !!}
                        {!! Form::file('picture', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('description', 'Omschrijving: ') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>


                    <!-- Form input -->
                    <div class="form-group" style="text-align: center;">
                        {!! Form::submit('Versturen', ['class' => 'btn btn-primary form-control']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop