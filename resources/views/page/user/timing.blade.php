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
                    <h1 class="color-darkblue flamenco text-center">
                        {{ 'tijdsregistratie voor ' . Auth::user()->voornaam . ' ' . Auth::user()->naam }}
                    </h1>
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

                    <div class="column-content-block">
                        @if(stristr($timingtype, 'cann'))
                            {{--Cannibale(tte) timings--}}
                            <table class="flamenco color-white">
                                <tr>
                                    <td colspan="2" class="flamenco color-white text-center" style="font-weight: bold;">
                                        La {{ $timingtype }} voor {{ Auth::user()->voornaam . ' ' . Auth::user()->naam }}
                                    </td>
                                </tr>
                                @foreach($timings as $checkpoint => $time)
                                    <tr>
                                        <td class="flamenco color-white">{{ ucfirst(str_replace(range(0,9),'',$checkpoint)) }}</td>
                                        <td class="lato color-white">
                                            @if($time == '00:00:00')
                                                <i>geen registratie</i>
                                            @else
                                                {!! $time !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Totale rittijd</td>
                                    <td class="lato color-white">{{ $cycletime }}</td>
                                </tr>
                            </table>
                        @elseif(stristr($timingtype, 'vent'))
                            <table class="flamenco color-white">
                                <tr>
                                    <td colspan="4" class="flamenco color-white text-center" style="font-weight: bold;">
                                        {{ $timingtype }} voor {{ Auth::user()->voornaam . ' ' . Auth::user()->naam }}<br />
                                        @if(count($timings)==1)
                                            <i>{{ count($timings) }} geregistreerde beklimming</i>
                                        @else
                                            <i>{{ count($timings) }} geregistreerde beklimmingen</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Startplaats</td>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Checkpoint</td>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Top Mont Ventoux</td>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Klimtijd</td>
                                </tr>

                                @foreach($timings as $climbing => $times)
                                    <tr>
                                        <td class="lato color-white">{{ ucfirst($times['startplace']) }}:
                                            @if($times['starttime'] == '00:00:00')
                                                <i>geen registratie</i>
                                            @else
                                                {{ $times['starttime'] }}
                                            @endif
                                        </td>
                                        <td class="lato color-white">{{ ucfirst($times['checkpointplace']) }}:
                                            @if($times['checkpointtime'] == '00:00:00')
                                                <i>geen registratie</i>
                                            @else
                                                {{ $times['checkpointtime'] }}
                                            @endif
                                        </td>
                                        <td class="lato color-white">
                                            @if($times['endtime'] == '00:00:00')
                                                <i>geen registratie</i>
                                            @else
                                                {!! $times['endtime'] !!}
                                            @endif
                                        </td>
                                        <td class="lato color-white">
                                            {!! $times['cycletime'] !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <table class="flamenco color-white">
                                <tr>
                                    <td colspan="4" class="flamenco color-white text-center" style="font-weight: bold;">
                                        Geen tijden gevonden voor {{ Auth::user()->voornaam . ' ' . Auth::user()->naam }}<br />
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </div>
                    <p style="text-align:center">
                    <div style="float: left;"><a class="button rounded blue medium" href="{{ url('/tijden/pdf') }}">visuele weergave</a></div>
                    <div style="float: right;"><a class="button rounded blue medium" href="{{ url('/tijden/diploma') }}">diploma</a></div>
                    </p>
                    <p style="text-align:center">
                        <a class="button rounded blue medium" href="{{ url('/home') }}">terug</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

@stop