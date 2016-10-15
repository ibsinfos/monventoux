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
                        {{ Auth::user()->formule . ' ' . Auth::user()->voornaam . ' ' . Auth::user()->naam }}
                    </h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">

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
            </div>
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered">
                    <div data-configid="0/36305706" style="width:525px; height:379px; margin: 0 auto;" class="issuuembed"></div>
                    <script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered">
                    <p style="text-align: center;">
                        <a class="button rounded blue medium centered" href="{{ url('/download/pdf/toeristische-gids-2016.pdf') }}">download</a>
                    </p>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered">
                    <p style="text-align: center;">
                        <a class="button rounded blue medium" href="{{ url('/home') }}">terug</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop