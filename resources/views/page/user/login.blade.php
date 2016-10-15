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
                    <h1 class="color-darkblue flamenco text-center">Inloggen</h1>
                </div>
            </div>
        </header>
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

                    {!! Form::open(['url'=>'/login']) !!}
                    <div class="columns small-12">
                        {!!Form::text('username',null,['required'=>'', 'autofocus'=>'', 'placeholder'=>'Gebruikersnaam'])!!}

                        {!!Form::password('password',['required' =>'' , 'minlength'=>6, 'placeholder'=>'Wachtwoord'])!!}
                    </div>
                    <div class="columns small-12 medium-6">
                        <button class="red rounded small" type="submit">Inloggen</button>
                    </div>
                    <div class="columns small-12 medium-6 text-right">
                        <a href="{{url('/password/email')}}">Wachtwoord vergeten?</a>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    </div>

@stop