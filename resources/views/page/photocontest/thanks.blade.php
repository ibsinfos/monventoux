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
                    <h1 class="color-darkblue flamenco text-center">Bedankt voor je foto</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">
                    <h4>Dag {{ $contester->surname . ' ' . $contester->name }}</h4>

                    <p>Fijn dat je deze leuke foto hebt ingestuurd:<br/></p>

                    <img src="{{ url($contester->picture) }}">

                    <p><br /><a href="{{url('/')}}" class="small button blue" target="_self">Home</a></p>
                </div>
            </div>

        </div>
    </div>
@stop