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


                        {!! Form::open(['url' => 'admin/nieuwsbeheer/'.$item->id.'/edit', 'files' => true]) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Titel: ') !!}
                            {!! Form::text('title', $item->title, ['class' => 'form-control', 'maxlength' => '255']) !!}
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('intro', 'Intro: ') !!}
                            {!! Form::text('intro', $item->intro, ['class' => 'form-control']) !!}
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('Body', 'Body: ') !!}
                            {!! Form::textarea('body', $item->body, ['class' => 'form-control', 'id' => 'body']) !!}
                        </div>
                        {{--CKEditor--}}
                        <script type="text/javascript">
                            CKEDITOR.replace( 'body',
                                    {
                                        customConfig : 'config.js',
                                        toolbar : 'simple'
                                    })
                        </script>

                        <div class="form-group">
                            <img src="../../../{{ $item->picture }}" width="400px">
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('picture', 'Afbeelding: ') !!}
                            {!! Form::file('picture', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('startdate', 'Start: ') !!}
                            {!! Form::text('startdate', date('d/m/Y',strtotime(substr($item->start, 0, 10))), ['class' => 'form-control', 'id' => 'startdatepicker']) !!}
                            {!! Form::text('starttime', substr($item->start, 11), ['class' => 'form-control']) !!}
                        </div>

                        <!-- form input -->
                        <div class="form-group">
                            {!! Form::label('enddate', 'Stop: ') !!}
                            @if($item->end == '0000-00-00 00:00:00')
                                {!! Form::text('enddate', '00/00/0000', ['class' => 'form-control', 'id' => 'enddatepicker', 'placeholder' => 'dd/mm/jjjj']) !!}
                                {!! Form::text('endtime', '00:00:00', ['class' => 'form-control']) !!}
                            @else
                                {!! Form::text('enddate', substr($item->start, 0, 10), ['class' => 'form-control', 'id' => 'enddatepicker', 'placeholder' => 'dd/mm/jjjj']) !!}
                                {!! Form::text('endtime', substr($item->start, 11), ['class' => 'form-control']) !!}
                            @endif
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