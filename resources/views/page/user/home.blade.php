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

{{--
                    @if(Auth::user()->medischefiche == '1900-01-01 00:00:00')
                        <div class="columns small-12 medium-6 large-4">
                            <a href="{{ url('/p/medisch') }}" class="button blue rounded columns small-12">Medisch attest</a>
                            <blockquote>&nbsp;</blockquote>
                        </div>
                    @endif
--}}
                        <div class="columns small-12 medium-6 large-4">
                            <a href="http://www.surveygizmo.com/s3/2787465/Enqu-te-Mon-Ventoux-2016" target="_blank" class="button blue rounded columns small-12">Deelnemers-<br>enquête</a>
                            <blockquote class="text-center">&nbsp;</blockquote>
                        </div>

                        <div class="columns small-12 medium-6 large-4">
                            <a href="{{ url('/downloadcorner') }}" class="button blue rounded columns small-12">Download corner</a>
                            <blockquote class="text-center">&nbsp;</blockquote>
                        </div>

                        <div class="columns small-12 medium-6 large-4">
                            <a href="{{ url('/toeristische-gids') }}" class="button blue rounded columns small-12">Toeristische info</a>
                            <blockquote class="text-center">&nbsp;</blockquote>
                        </div>

                        <div class="columns small-12 medium-6 large-4">
                            <a href="{{ url('/programma') }}" class="button blue rounded columns small-12">Mijn programma</a>
                            <blockquote class="text-center">&nbsp;</blockquote>
                        </div>

                        <div class="columns small-12 medium-6 large-4">
                            <a href="{{ url('/tijden') }}" class="button blue rounded columns small-12">Mijn<br>tijden</a>
                            <blockquote class="text-center">&nbsp;</blockquote>
                        </div>

                        <div class="columns small-12 medium-6 large-4">
                            <a href="{{ url('/klassement') }}" class="button blue rounded columns small-12">Alle<br />tijden</a>
                            <blockquote class="text-center">&nbsp;</blockquote>
                        </div>

				</div>
			</div>
		</div>
	</div>

@stop