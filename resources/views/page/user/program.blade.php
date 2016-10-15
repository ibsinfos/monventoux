@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-pagehead')
    @include('partials.partial-menu')

    <div class="page-sections">
        <header class="page-header">
            <div class="row">
                <div class="columns small-48 medium-40 large-24 medium-centered end">
                    <h1 class="color-darkblue flamenco text-center">Jouw programma in Frankrijk</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-24 medium-20 large-16 medium-centered end">

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

                    <div class="row">
                        <h3>{{ 'Hallo ' . Auth::user()->voornaam }}</h3>
                        Op 18 juni schrijf jij je eigen stukje fietsgeschiedenis op de Mont Ventoux. Om jou {{ ucfirst(Auth::user()->formule) }} tot in de puntjes te doen slagen, vind je hier jouw persoonlijke programma.
                    </div>
                    @if(stristr(Auth::user()->formule, 'cann'))
                    {{--Cannibale(tte) program--}}
                        <div class="row">
                            <fieldset>
                                <legend>Jouw fietsprestatie</legend>
                                <table class="lato">
                                    <tr>
                                        <td width="15%">Vrijdag 17 juni</td>
                                        <td widht="10%">10-18u</td>
                                        <td width="75%">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Meld je aan bij balie {{ Auth::user()->aanmeldbalie }}</strong> met je identiteitskaart en Mon Ventoux-lidkaart.<br /> Adres: Avenue Barral des Beaux in Bédoin.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" style="min-width: 600px; min-height: 450px;" src="https://player.vimeo.com/video/169096877?autoplay=1"></iframe>
                                        </td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Je krijgt een <strong>enveloppe</strong> met jouw fietsplaatje met chip tijdsregistratie, jouw polsbandje, een infokaartje, wijnbonnen én een buissticker met hoogteprofielen. Hou het goed bij voor de start op zaterdag.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <table class="lato">
                                    <tr>
                                        <td width="50%">Zaterdag 18 juni</td>
                                        <td width="15%">5u45</td>
                                        <td width="35%">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Opening startvlakken</strong> in Cours des Isnards, Malaucène.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3"><a href="{{ url('assets/img/parcours/parcours-' . Auth::user()->formule . '.png') }}" target ="_blank"><img src="{{ url('assets/img/parcours/parcours-' . Auth::user()->formule . '.png') }}"></a></td>
                                        <td>6u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Het officiële startschot voor La {{ Auth::user()->formule }} wordt gegeven door Eddy Merckx.<br />
                                                    Let op: dit is een verplicht groepsvertrek &rArr; 1 startmogelijkheid.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Tijdslimiet</strong> aanvang slotbeklimming vanuit Sault.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>19u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Einde tijdsregistratie</strong> op de </strong>top</strong> van de Mont Ventoux.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                        <div class="row">Bij een puike prestatie horen natuurlijk ook extra’s. Zo maak jij van Mon Ventoux 2016 een all-in-top-beleving.</div>
                        <div class="row">
                            <fieldset>
                                <legend>Jouw Mon Ventoux-beleving</legend>
                                <table class="lato">
                                    <tr>
                                        <td width="15%">Vrijdag 17 juni</td>
                                        <td width="10%">Hele dag</td>
                                        <td width="75%">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Warm je op met <strong>3 uitgepijlde fietstochten</strong> met zicht op de Mont Ventoux. De gpx-bestanden voor deze La Vintoux download je <a href="{{ url('download/gpx/gpx-la-vintoux.zip') }}">hier</a>.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>10-18u</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Bij het aanmelden in Bédoin krijg je ook een <strong>gratis t-shirt en goodiebag</strong>.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>10-18u</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Haal je <strong>drinkbus en Isotonic poeder</strong> op aan de Etixx-stand (op de parking) bij het aanmelden.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>10-18u</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Laat je <strong>fiets checken</strong> bij de Vlaamse Wielerschool.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <table class="lato">
                                    <tr>
                                        <td width="15%">Zaterdag 18 juni</td>
                                        <td width="10%">16-01u</td>
                                        <td width="75%">
                                            In <strong>Village Cannibale</strong> verwelkomen we je voor een feestje aan de voet van de Mont Ventoux!
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>16-19u</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Geniet van <strong>Cocktail</strong>, een Franse muziekgroep
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>19-20u</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Heerlijk nazinderen bij een aperitiefconcert van <strong>BuitenBereik</strong>.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>20u00-<br>20u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Podiummoment</strong>. Wie gaan naar huis met de Eddy Merckx fiets?
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>20u30-<br>22u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>BuitenBereik</strong>, een Nederlandstalige coverband, kalt het feestje opnieuw in gang.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>22u30-<br>01u00</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Helemaal los ga je op <strong>Discobaar A Moeder</strong>, de revelatie op Laundry Day, Pukkelpop en Night of the Proms
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                    @elseif(Auth::user()->formule == 'ventourist')
                        {{-- ventourist program --}}
                        <div class="row">
                            <fieldset>
                                <legend>Jouw fietsprestatie</legend>
                                <table class="lato">
                                    <tr>
                                        <td width="50%">Vrijdag 17 juni</td>
                                        <td widht="15%">10-18u</td>
                                        <td width="35%">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Meld je aan bij balie {{ Auth::user()->aanmeldbalie }}</strong> met je identiteitskaart en Mon Ventoux-lidkaart.<br /> Adres: Avenue Barral des Beaux in Bédoin.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" style="min-width: 600px; min-height: 450px;" src="https://player.vimeo.com/video/169096877?autoplay=1"></iframe>
                                        </td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Je krijgt een <strong>enveloppe</strong> met jouw fietsplaatje met chip tijdsregistratie, jouw polsbandje, een infokaartje, wijnbonnen én een buissticker met hoogteprofielen. Hou het goed bij voor de start op zaterdag.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <table class="lato">
                                    <tr>
                                        <td width="50%">Zaterdag 18 juni</td>
                                        <td width="15%">7u</td>
                                        <td width="35%">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Opening startvlakken</strong>. Je kan starten vanuit Bédoin, Malaucène en Sault tot 17u30<br />
                                                    Adressen:
                                                    <ul>
                                                        <li>Parking St. Marcellin, Bédoin</li>
                                                        <li>Cours des Isnards, Malaucène</li>
                                                        <li>Place de la Promenade, Sault</li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3"><a href="{{ url('assets/img/parcours/parcours-' . Auth::user()->formule . '.png') }}" target ="_blank"><img src="{{ url('assets/img/parcours/parcours-' . Auth::user()->formule . '.png') }}"></a></td>
                                        <td>7u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    Het officiële startschot voor {{ Auth::user() ->formule }} wordt gegeven.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Einde tijdsregistratie</strong> in de <strong>startdorpen</strong>.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>19u30</td>
                                        <td style="vertical-align: text-top;">
                                            <ul style="list-style-position: outside; margin-left: 1em;">
                                                <li style="list-style-position: outside; margin-left: 1em;">
                                                    <strong>Einde tijdsregistratie</strong> op de </strong>top</strong> van de Mont Ventoux.
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                        <div class="row">Bij een puike prestatie horen natuurlijk ook extra’s. Zo maak jij van Mon Ventoux 2016 een all-in-top-beleving.</div>
                            <div class="row">
                                <fieldset>
                                    <legend>Jouw Mon Ventoux-beleving</legend>
                                    <table class="lato">
                                        <tr>
                                            <td width="15%">Vrijdag 17 juni</td>
                                            <td width="10%">Hele dag</td>
                                            <td width="75%">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Warm je op met <strong>3 uitgepijlde fietstochten</strong> met zicht op de Mont Ventoux. De gpx-bestanden voor deze La Vintoux download je <a href="{{ url('download/gpx/gpx-la-vintoux.zip') }}">hier</a>.
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>10-18u</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Bij het aanmelden in Bédoin krijg je ook een <strong>gratis t-shirt en goodiebag</strong>.
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>10-18u</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Haal je <strong>drinkbus en Isotonic poeder</strong> op aan de Etixx-stand (op de parking) bij het aanmelden.
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>10-18u</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Laat je <strong>fiets checken</strong> bij de Vlaamse Wielerschool.
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                    <br />
                                    <table class="lato">
                                        <tr>
                                            <td width="15%">Zaterdag 18 juni</td>
                                            <td width="10%">16-01u</td>
                                            <td width="75%">
                                                In <strong>Village Cannibale</strong> verwelkomen we je voor een feestje aan de voet van de Mont Ventoux!
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>16-19u</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Geniet van <strong>Cocktail</strong>, een Franse muziekgroep
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>19-20u</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Heerlijk nazinderen bij een aperitiefconcert van <strong>BuitenBereik</strong>.
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>20u00-<br>20u30</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        <strong>Podiummoment</strong>. Wie gaan naar huis met de Eddy Merckx fiets?
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>20u30-<br>22u30</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        <strong>BuitenBereik</strong>, een Nederlandstalige coverband, kalt het feestje opnieuw in gang.
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>22u30-<br>01u00</td>
                                            <td style="vertical-align: text-top;">
                                                <ul style="list-style-position: outside; margin-left: 1em;">
                                                    <li style="list-style-position: outside; margin-left: 1em;">
                                                        Helemaal los ga je op <strong>Discobaar A Moeder</strong>, de revelatie op Laundry Day, Pukkelpop en Night of the Proms
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                    @endif
                    <br />
                    <p style="text-align:center">
                        <a class="button rounded blue medium" href="{{ url('/home') }}">terug</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

@stop