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
                    <h1 class="color-darkblue flamenco text-center">{{$title}}</h1>
                        <h4 class="color-darkblue lato text-italic text-center">{{$subtitle}}</h4>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                @if(Session::has('status'))
                    <div class="columns end medium-10 medium-centered large-8">

                        <div class="panel">
                            <p>{{ Session::get('status') }}</p>
                        </div>
                    </div>
                @endif
                <div class="clearfix"></div>
                @foreach($photos as $photo)
                    <a class="columns small-6 medium-3 large-2 end"
                       href="https://www.flickr.com/photos/mijnventoux/{{$photo['id']}}/in/album-{{$set}}/"
                       target="_blank">
                                <figure class="flickr-thumb">
                        <img src="{{$photo['url_s']}}" title="{{$photo['title']}}"></figure></a>
                @endforeach
                </div>
            <br />
            <p style="text-align:center">
                <a class="button rounded blue medium" href="{{ url('/eventfotos') }}">terug</a>
            </p>
            </div>
        </div>
    </div>

@stop