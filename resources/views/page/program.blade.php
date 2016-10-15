@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-programhead')
    @include('partials.partial-menu')

    <div class="row intro">
        @include('partials.page.intro-content')

        <div class="columns small-12 medium-4 large-3 large-offset-2 color-white">
            <!--a href="{{url('/inschrijven')}}" class="button rounded {{$color}}">Nu inschrijven<br/>
                <small>voor Mon Ventoux 2017</small>
            </a-->
            Inschrijven vanaf 15 oktober<br>
        </div>
    </div>

    <div class="page-sections">
        <header class="page-header">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    <h1 class="color-darkblue flamenco text-center">{{$page->title}}</h1>
                    @if(isset($page->subtitle))
                        <h4 class="color-darkblue lato text-italic text-center">{{$page->subtitle}}</h4>
                    @endif
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    {!!$page->body!!}
                </div>
            </div>
        </div>
        @include("partials.partial-eventinfo")
    </div>

    <section class="section-eventinfo">
    </section>
    <section class="section-quotes">
        {{--@include("partials.partial-quotes")--}}
    </section>
    <section class="section-images scroll-section images-with-button" id="images">
        @include("partials.partial-images")
        <a href="{{ url('/eventfotos') }}" class="button white color-darkblue rounded small lato text-centered expanded">Meer foto's</a>
    </section>
    <section class="section-what">
        {{--@include("partials.program.what-i-get")--}}
    </section>

@stop