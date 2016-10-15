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
                    <h1 class="color-darkblue flamenco text-center">Paswoord resetten</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">

                    <div class="columns small-12">
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

                    {!! Form::open(['url'=>'/password/email','class'=>'form validator','novalidate'=>'']) !!}

                    <div class="columns small-12">
                        {!!Form::label('username','Gebruikersnaam')!!}
                        {!!Form::email('username',null,['required'=>'', 'autofocus'=>''])!!}
                        <button class="red rounded small" type="submit">Herstel wachtwoord</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop