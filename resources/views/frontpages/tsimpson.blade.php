@extends('main')

@section('content')

    <figure class="banner fixed home">
        <div class="row">
            <div class="columns small-12 medium-10 large-8 medium-centered" scrollfade>
                <h2 class="color-white flamenco text-center">{!! $slogan !!}</h2><h4
                        class="color-white lato text-italic text-center">{{$eventdate}}</h4>
            </div>
        </div>
    </figure>

    @include('partials.partial-menu')

    <div class="home-sections">
        <div style="text-align: center;">
            <a href="{{url('/p/overtomsimpson')}}" class="button gold rounded small lato text-centered expanded" scrollfade>Tom Simpson: 1967-2017</a>
            <!--a href="{{url('/')}}" class="cta-hom button gold rounded small lato text-centered expanded" scrollfade>Schrijf nu in</-->
        </div>

        <section class="section-event scroll-section" id="event">
            @include("partials.partial-tsimpson-buttons")
        </section>
        <section class="section-images scroll-section images-with-button" id="images">
            @include("partials.partial-images")
            <a href="{{ url('/eventfotos') }}" class="button white color-darkblue rounded small lato text-centered expanded">Meer foto's</a>
        </section>
        <section class="section-blog scroll-section" id="blog">
                <div class="row" style="width: 95%;">
                    @include("partials.partial-tsimpson-video")
                    @include("partials.partial-news")
                </div>
        </section>
        @if($quotes['hasquote'])
            <section class="section-quotes scroll-section" id="quotes">
                @include("partials.partial-quotes")
            </section>
        @endif
        <section class="section-newsletter scroll-section" id="newsletter">
            @include("partials.partial-newsletter", ['vimeo'=>true]);
        </section>
        <section class="section-partners scroll-section" id="partners">
            @include("partials.partial-partners")
        </section>

    </div>

@stop