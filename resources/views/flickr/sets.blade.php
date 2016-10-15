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
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns end medium-10 medium-centered large-8">
                    @if(Session::has('status'))
                    <div class="panel">
                        <p>{{ Session::get('status') }}</p>
                    </div>
                    @endif
                    <ul>
                    @foreach($sets as $set)
                        <li><a href="{{url('/eventfotos/'.$set->flickr_id)}}">{{$set->title}}</a></li>
                    @endforeach
                    </ul>
                </div>
                <br />
                <p style="text-align:center">
                    <a class="button rounded blue medium" href="{{ url('/') }}">terug</a>
                </p>

            </div>
        </div>
    </div>

@stop