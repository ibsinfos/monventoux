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
                        Profiel {{ Auth::user()->voornaam . ' ' . Auth::user()->naam }}
                    </h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">

                    <h3 class="text-center">Medisch attest</h3>
                        @if(Auth::user()->medischefiche == '1900-01-01 00:00:00')
                            <p class="text-center">
                                We hebben nog geen medisch attest ontvangen. Je kan het medisch attest <a href="{{url('/medischattest')}}" target="_blank">hier</a> downloaden.
                                <a href="{{url('/medischattest')}}" target="_blank">Medisch attest downloaden</a>
                            </p><br>
                        @else
                            <p class="text-center">
                                We hebben uw medisch attest reeds ontvangen.
                            </p>
                        @endif  
                    <hr>
                    <h3 class="text-center">Volledig beheer dossiergegevens volgt later.</h3>


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

					{!!Form::open()!!}
                        <h1 class="text-center">{{ ucfirst(Auth::user()->formule) }}</h1>

						{!!Form::label('straatennummer','Straat en nummer')!!}
						{!!Form::text('straatennummer',Auth::user()->straatennummer,['required'=>''])!!}

						{!!Form::label('postcode','Postcode')!!}
						{!!Form::text('postcode',Auth::user()->postcode,['required'=>''])!!}

						{!!Form::label('woonplaats','Woonplaats')!!}
						{!!Form::text('woonplaats',Auth::user()->woonplaats,['required'=>''])!!}

                        {!!Form::label('land','Land')!!}
                        {!!Form::select('land',$landen,Auth::user()->land )!!}                        

                        {!!Form::label('email','Email adres')!!}
                        {!!Form::text('email',Auth::user()->email)!!}                       

						{!!Form::label('gsm','Gsm-nummer')!!}
						{!!Form::text('gsm',Auth::user()->gsm)!!}

	                    <div class="columns small-12 medium-6">
	                        <button class="red rounded small" type="submit">Bewaren</button>
	                    </div>

					{!!Form::close()!!}
				</div>
			</div>
		</div>
	</div>

@stop