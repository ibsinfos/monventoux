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
                    <h1 class="color-darkblue flamenco text-center">Aanvraag testdagen</h1>
                    <p>Aanvraag voor {{$user->voornaam}} {{$user->naam}} registreren:</p>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">

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

                    {!! Form::open() !!}
                        <fieldset>
                            <legend>Kies jouw plaats en moment</legend>
                            <fieldset>
                                <legend>Tongerlo</legend>
                                <span style="color: red; font-weight: bold;">VOLZET</span> woensdag 20 januari 2016 : 18.00 - 22.00<br>
                                <span style="color: red; font-weight: bold;">VOLZET</span> donderdag 21 januari 2016 : 09.00 - 12.00<br>
                                {{--{!!Form::radio('block','T3', array('required' => 'required'))!!}<label for="T3">donderdag 21 januari 2016 : 13.00 - 17.00</label>--}}
                                <span style="color: red; font-weight: bold;">VOLZET</span> donderdag 21 januari 2016 : 13.00 - 17.00
                            </fieldset>
                            <fieldset>
                                <legend>Wuustwezel</legend>
                                <span style="color: red; font-weight: bold;">VOLZET</span> vrijdag 19 februari 2016 : 18.00 - 22.00<br>
                                <span style="color: red; font-weight: bold;">VOLZET</span> zaterdag 20 februari 2016 : 09.00 - 12.00<br>
                                <span style="color: red; font-weight: bold;">VOLZET</span> zaterdag 20 februari 2016 : 13.00 - 17.00<br>
                                <span style="color: red; font-weight: bold;">VOLZET</span> vrijdag 26 februari 2016 : 18.00 - 22.00<br>
                                <span style="color: red; font-weight: bold;">VOLZET</span> zaterdag 27 februari 2016 : 09.00 - 12.00<br>
                                <span style="color: red; font-weight: bold;">VOLZET</span> zaterdag 27 februari 2016 : 13.00 - 17.00
                            </fieldset>
                        </fieldset>
                        Helaas zijn alle mogelijkheden volzet.
                        <!--fieldset>
                            <legend>Maak je keuze</legend>
                            {{--{!!Form::radio('product','P1', array('required' => 'required'))!!}<label for="P1">Sportmedische keuring (&euro;&nbsp;60,00)</label><br>--}}
                            {{--{!!Form::radio('product','P2', null, ['style' => 'vertical-align: text-top; float: left;'])!!}<label for="P2" style="float: inherit; margin-top: -3px;">Inspanningstest en lactaatmeting (&euro;&nbsp;140,00)<br>Let op: geldig attest van eerdere sportmedische keuring vereist!</label><br>--}}
                            {{--{!!Form::radio('product','P3')!!}<label for="P3">Sportmedische keuring + inspanningstest en lactaatmeting (&euro;&nbsp;155,00)</label>--}}
                        </fieldset-->

                    <div class="columns small-12 medium-6">
                        {{--<button class="red rounded small" type="submit">Gegevens doorsturen</button>--}}
                    </div>

                    {!! Form::close() !!}
                    <div class="columns small-12 medium-6">
                        <a href="{{ url('/p/testdagen') }}"><button class="red rounded small">Terug</button></a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop