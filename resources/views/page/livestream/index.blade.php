@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-pagehead')
    @include('partials.partial-menu')

    <div class="page-sections">
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">

                    @if(isset($errors))
                        <div>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('status'))
                        <div>
                            <p>{{ Session::get('status') }}</p>
                        </div>
                    @endif

           </div>
           <div class="row">

                <div class="columns small-48 medium-24 large-12 large-offset-1 medium-centered end">
                        <div class="iframecontainer">
                            <iframe width="720" height="405" src="{{ $urlstream }}" scrolling="no" allowfullscreen webkitallowfullscreen frameborder="0" style="border: 0 none transparent;"></iframe>
                        </div>
                    <p>{!! $msg !!}</p>

                    <br />
                    <p style="text-align:center">
                        <a class="button rounded blue medium" href="{{ url('/') }}">terug</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>

@stop