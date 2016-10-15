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
                    <h1 class="color-darkblue flamenco text-center">{{$page->title}}</h1>
                    @if(isset($page->subtitle))
                        <h4 class="color-darkblue lato text-italic text-center">{{$page->subtitle}}</h4>
                    @endif
                </div>
            </div>
        </header>
        @if(count($pagepictures)>0)
            <section class="section-images scroll-section" id="images">
            <?php $mediadata = $pagepictures;?>
            @include('partials.partial-images')
            </section>
        @endif
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    @if(Session::has('status'))
                        <div class="panel">
                            <p>{{ Session::get('status') }}</p>
                        </div>
                    @endif        
                    {!!$page->body!!}
                </div>
            </div>
        </div>
    </div>

@stop