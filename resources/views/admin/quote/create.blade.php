@extends('main')

@section('content')

    <figure class="banner fixed page"></figure>

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
                    <h2>nieuwe quote</h2>

                    @if(Session::has('status'))
                        <div>
                            <p>{!! Session::get('status') !!}</p>
                        </div>
                    @endif

                    {!! Form::open(['url' => 'admin/quotebeheer', 'files' => true]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Naam: ') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => '255']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('txt', 'Tekst: ') !!}
                        {!! Form::text('txt', null, ['class' => 'form-control', 'maxlength' => '255']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('picture', 'Afbeelding: ') !!}
                        {!! Form::file('picture', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Form input -->
                    <div class="form-group">
                        {!! Form::submit('Bewaar', ['class' => 'btn btn-primary form-control']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop