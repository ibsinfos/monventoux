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
                        Beheer quotes
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


                        {!! Form::open(['url' => 'admin/quotebeheer/'.$quote->id.'/edit', 'files' => true]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Naam: ') !!}
                            {!! Form::text('name', $quote->name, ['class' => 'form-control', 'maxlength' => '255']) !!}
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('txt', 'Tekst: ') !!}
                            {!! Form::text('txt', $quote->txt, ['class' => 'form-control', 'maxlength' => '255']) !!}
                        </div>

                        <div class="form-group">
                            @if($quote->img <> '')
                                <img src="../../../{{ $quote->img }}" width="100px">
                            @else
                                <img src="{{ asset('assets/img/no-picture.png') }}" width="100px">
                            @endif
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('picture', 'Afbeelding: ') !!}
                            {!! Form::file('picture', null, ['class' => 'form-control']) !!}
                        </div>


                        <!-- Form input -->
                        <div class="form-group">
                            {!! Form::submit('Bewaar', ['class' => 'btn btn-primary form-control']) !!}
                            <a class="btn-close" href="{{ url('admin/quotebeheer') }}">Annuleren</a>
                        </div>

                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop