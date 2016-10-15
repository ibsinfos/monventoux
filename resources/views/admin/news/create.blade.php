@extends('main')

@section('content')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#startdatepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
            $( "#enddatepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
    </script>

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
                    <h2>nieuw item</h2>

                    @if(Session::has('status'))
                        <div>
                            <p>{!! Session::get('status') !!}</p>
                        </div>
                    @endif

                    {!! Form::open(['url' => 'admin/nieuwsbeheer', 'files' => true]) !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Titel: ') !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'maxlength' => '255']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('intro', 'Intro: ') !!}
                        {!! Form::text('intro', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('Body', 'Body: ') !!}
                        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('picture', 'Afbeelding: ') !!}
                        {!! Form::file('picture', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('startdate', 'Start: ') !!}
                        {!! Form::text('startdate', date('d/m/Y'), ['class' => 'form-control', 'id' => 'startdatepicker']) !!}
                        {!! Form::text('starttime', date('H:i:s'), ['class' => 'form-control']) !!}
                    </div>

                    <!-- form input -->
                    <div class="form-group">
                        {!! Form::label('enddate', 'Stop: ') !!}
                        {!! Form::text('enddate', '00/00/0000', ['class' => 'form-control', 'id' => 'enddatepicker', 'placeholder' => 'dd/mm/jjjj']) !!}
                        {!! Form::text('endtime', '00:00:00', ['class' => 'form-control']) !!}
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