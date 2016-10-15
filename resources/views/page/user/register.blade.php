@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-pagehead')
    @include('partials.partial-menu')

    <script>
        fbq('track', 'InitiateCheckout');
    </script>

    <div class="page-sections">
        <header class="page-header">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    @if(isset($dossierid))
                        <h1 class="color-darkblue flamenco text-center">Voeg nieuwe deelnemer toe</h1>
                    @else
                        <h1 class="color-darkblue flamenco text-center">Inschrijven</h1>
                    @endif
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">
                    <div class="columns small-12">
                        @if(isset($errors))
                            <div>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(Session::has('status'))
                            <div>
                                <p>{{ Session::get('status') }}</p>
                            </div>
                        @endif
                    </div>
                    @if(!Auth::check() || Auth::user()->bedrijf != 'Sporta Admin')
                        <div class="columns small-12">
                            De laatste deelnamebewijzen zijn definitief de deur uit. Inschrijven voor Mon Ventoux 2016 is helaas niet meer mogelijk.
                        </div>
                    @else

                        <div class="columns small-12">

                            {!! Form::open(['novalidate'=>'']) !!}
                            {!! Form::open() !!}

                            <div class="panel">
                                <h5>Opgelet</h5>
                                <p>De keuze voor Ventourist of Cannibale(tte) kan na inschrijving niet meer ongedaan gemaakt worden.</p>
                            </div>
                            {!!Form::label('soort','Deelnemen als')!!}
                            {!!Form::select('soort',$soorten,'',['required'=>'','autofocus'=>'','class'=>'toggleTrigger'])!!}

                            {!!Form::label('username','Gebruikersnaam')!!}
                            {!!Form::text('username',null,['required'=>''])!!}

                            {!!Form::label('email','Email')!!}
                            {!!Form::email('email',null,['required-email'=>''])!!}

                            {!!Form::label('password','Kies een paswoord')!!}
                            {!!Form::password('password',null,['required'=>''])!!}

                            {!!Form::label('password_confirmation','Herhaal paswoord')!!}
                            {!!Form::password('password_confirmation',null,['required'=>''])!!}

                            {!!Form::label('voornaam','Voornaam')!!}
                            {!!Form::text('voornaam',null,['required'=>''])!!}

                            {!!Form::label('naam','Naam')!!}
                            {!!Form::text('naam',null,['required'=>''])!!}

                            {!!Form::label('straatennummer','Straat en nummer')!!}
                            {!!Form::text('straatennummer',null,['required'=>''])!!}

                            {!!Form::label('postcode','Postcode')!!}
                            {!!Form::text('postcode',null,['required'=>''])!!}

                            {!!Form::label('woonplaats','Woonplaats')!!}
                            {!!Form::text('woonplaats',null,['required'=>''])!!}

                            {!!Form::label('land','Land')!!}
                            {!!Form::select('land',$landen,'BE')!!}

                            {!!Form::label('geboortedatum','Geboortedatum (dd/mm/yyyy)')!!}
                            {!!Form::text('geboortedatum',null,['required-pattern'=>'','patternerrormsg'=> 'Vul een geldige datum in.', 'class'=>'datepicker','pattern'=>'^[0-9]{1,2}[/][0-9]{1,2}[/][0-9]{4}$'])!!}

                            {!!Form::label('geslacht','Geslacht')!!}
                            {!!Form::select('geslacht',$geslachten,'',['required'=>''])!!}

                            {!!Form::label('gsm','Gsm-nummer')!!}
                            {!!Form::text('gsm',null)!!}

                            <div class="panel">
                                <h5>Opgelet</h5>
                                <p>De keuzes 'CM-lid' en 'annulatieverzekering' kunnen na inschrijving niet meer ongedaan gemaakt worden.</p>
                            </div>

                            {!!Form::label('annulatieverzekering','Ik wil een annulatieverzekering voor mijn deelnamegeld (€ 5)')!!}
                            {!!Form::checkbox('annulatieverzekering','1',false)!!}
                            <br>
                            {!!Form::label('cmlid','Lid CM? 5 € korting')!!}
                            {!!Form::checkbox('cmlid','1',false)!!}
                            <br>

                            {!!Form::label('cmlidnummer','CM lidnummer')!!}
                            {!!Form::text('cmlidnummer',null,['maxlength'=>'15'])!!}

                            {!!Form::label('tshirtmaat','T-shirt maat')!!}
                            {!!Form::select('tshirtmaat',$maten,null)!!}

                            {!!Form::label('nationaliteit','Nationaliteit')!!}
                            {!!Form::select('nationaliteit',$nationaliteiten,'BE')!!}

                            {!!Form::label('rijksregisternummer','Rijksregisternummer (11 cijfers - geen leestekens)')!!}
                            {!!Form::text('rijksregisternummer',null,['maxlength'=>"11",'pattern'=>'^[0-9]{11}$'])!!}

                            {!!Form::label('sofinummer','Sofinummer (8-9 cijfers - geen leestekens)')!!}
                            {!!Form::text('sofinummer',null,['maxlength'=>"9",'pattern'=>'^[0-9]{8,9}$'])!!}

                            {!!Form::label('fietsfrequentie','Fietsfrequentie')!!}
                            {!!Form::select('fietsfrequentie',$fietsfrequentie,null)!!}

                            {!!Form::checkbox('algemenevoorwaarden','1',false,['required'=>'','id'=>'algemenevoorwaarden'])!!}
                            <label for="algemenevoorwaarden">Ik accepteer de <a
                                        href="{{ url('download/pdf/algemene-voorwaarden-2016.pdf') }}"
                                        target="_blank">algemene voorwaarden</a></label> <br>

                            {!!Form::checkbox('gedragscode','1',false,['required'=>'','id'=>'gedragscode'])!!}
                            <label for="gedragscode">Ik accepteer de <a
                                        href="{{ url('download/pdf/gedragscode-2016.pdf') }}"
                                        target="_blank">gedragscode</a></label> <br>

                            {!!Form::checkbox('attest','1',false,['required'=>'','id'=>'attest'])!!}
                            <label for="attest">Ik lever het medisch attest in v&oacute;&oacute;r 15 mei 2016. (*)</label><br>
                            <i>(*) Download jouw gepersonaliseerd medisch attest in jouw profiel nadat je geregistreerd bent. Dit laat je dan invullen en ondertekenen door een (sport)arts en bezorg je terug aan Sporta. Klik <a href="{{url('/p/medisch')}}" target="_blank">hier</a> voor meer info.</i>
                            <br>
                            <br>
                            <button class="red rounded small" type="submit">Versturen</button>
                            {!! Form::close() !!}
                        </div
                    @endif

                </div>
            </div>
        </div>
    </div>

@stop
