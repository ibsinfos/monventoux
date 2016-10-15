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
                        Overzicht tijden alle deelnemers
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
                            <table class="flamenco color-white">
                                <tr>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Naam</td>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Type</td>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Startplaats</td>
                                    <td class="flamenco color-white text-center" style="font-weight: bold;">Tijd</td>
                                </tr>
                                @foreach($timings as $timing)
                                    <tr>
                                        <td class="flamenco color-white">{{ $timing['naam'] }}</td>
                                        <td class="flamenco color-white">{{ $timing['categorie'] }}</td>
                                        <td class="flamenco color-white">{{ $timing['startplaats'] }}</td>
                                        <td class="lato color-white">
                                            @if($timing['klimtijd'] == '00:00:00')
                                                <i>geen registratie</i>
                                            @else
                                                {!! $timing['klimtijd'] !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                    </div>
                    <p style="text-align:center">
                        <a class="button rounded blue medium" href="{{ url('/home') }}">terug</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

@stop