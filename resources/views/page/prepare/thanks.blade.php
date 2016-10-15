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
                    <h1 class="color-darkblue flamenco text-center">Bedankt</h1>
                    <h4 class="color-darkblue lato text-italic text-center">Je bent nu ingeschreven voor de Mon Ventoux-dag in {{$subscription->route->location}}</h4>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    <p>We hebben een e-mail gestuurd naar "<strong>{{$subscription->email}}</strong>" met alle praktische info. </p>
                </div>
            </div>
        </div>
    </div>

@stop