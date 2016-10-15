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
                        Beheer nieuwsitems
                    </h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-36 medium-24 large-18 medium-centered end">

                    @if(isset($errors))
                        <div>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{!! $error !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('status'))
                        <div>
                            <p>{!! Session::get('status') !!}</p>
                        </div>
                    @endif

                        <div class="columns small-12 medium-6">
                            <a href="{{$quote['id']}}/edit" class="button rounded blue tiny">Aanpassen</a>
                        </div>
                        <br />
                        <br />
                        <div class="column-content-block">
                            <h4 class="flamenco color-white">{{$quote['name']}}</h4>
                            <p>
                            @if($quote['img'] <> '')
                                    <img src="{{asset($quote['img'])}}" width="100px">
                            @else
                                    <img src="{{asset('assets/img/no-picture.png')}}" width="100px">
                            @endif
                            </p>
                            <p class="lato color-white">{!! $quote['txt'] !!}</p>
                        </div>
                </div>
            </div>
        </div>
    </div>

@stop