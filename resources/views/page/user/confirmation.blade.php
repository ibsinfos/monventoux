@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-pagehead')
    @include('partials.partial-menu')

    <script>
        fbq('track', 'CompleteRegistration');
    </script>

    <div class="page-sections">
        <header class="page-header">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    <h1 class="color-darkblue flamenco text-center">Bevestiging inschrijving</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">

                    Beste {{ $user->voornaam }},<br><br>

                    <p>Fijn dat je gekozen hebt voor Mon Ventoux. Samen maken we van jouw uitdaging op 18 juni 2016 een sportief en extrasportief hoogtepunt.</p>
                    <p>
                        Een e-mail met jouw login-gegevens hebben we verstuurd naar: “{{ $user->email }}”
                    </p>
         
                    <h2>VRAGEN?</h2> 
                    <p>
                        Wij zijn er om jou te helpen. <br>
                        E info@monventoux.be  <br>
                        T 014 53 95 75
                    </p>

                    <div class="columns small-12 medium-6">
                        <a href="{{ url('/gebruiker') }}"><button class="red rounded small">Profiel</button></a>
                    </div>                    
                    <div class="columns small-12 medium-6">
                        <a href="{{ url('/') }}"><button class="red rounded small">Homepage</button></a>
                    </div>                    

                </div>
            </div>
        </div>
    </div>
    </div>

@stop