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
                    <h1 class="color-darkblue flamenco text-center">Nieuws</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-24 medium-16 large-8 medium-centered">

                    @foreach($newsitems as $item)
                        <div class="column-content-block">
                            <h4 class="flamenco color-white">{{$item['title']}}</h4>
                            <p class="lato text-italic color-white">{!! $item['intro'] !!}</p>
                            @unless($item['picture'] == '')
                                <p>
                                <img src="{{asset($item['picture'])}}">
                                </p>
                            @endunless
                            <p class="lato color-white">{!! $item['body'] !!}</p>
                        </div>
                        <br />
                    @endforeach
                        <p style="text-align:center">
                            <a class="button rounded darkblue medium" href="http://www.monventoux.be#keep-me-posted">Hou mij op de hoogte<br />
                                <small>Ja, ik wil de nieuwsbrief</small></a></p>
                </div>
            </div>
        </div>
    </div>
@endsection