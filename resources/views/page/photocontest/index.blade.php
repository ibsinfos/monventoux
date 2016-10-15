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
                        Fotowedstrijd inzendingen
                    </h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-36 medium-24 large-18 medium-centered end">
                    @foreach($photos as $photo)
                        <div style="clear: both; border-bottom: 1px solid #000000;">
                            <p>{!! $photo['surname'] !!} {!! $photo['name'] !!} ({!! $photo['participant'] !!})</p>
                            <img src="{{ url($photo['picture']) }}">
                            <p>{!! $photo['description'] !!}</p>
                        </div>
                    @endforeach
                    <div>
                        Ga naar
                    {!! $photos->render() !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="page-content">
            <div class="row">
                <div class="columns small-36 medium-24 large-18 medium-centered end">

                    @if(Session::has('status'))
                        <div>
                            <p>{!! Session::get('status') !!}</p>
                        </div>
                    @endif

               </div>
            </div>
        </div>
    </div>

@stop