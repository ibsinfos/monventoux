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
                    <h1 class="color-darkblue flamenco text-center">Aanmelden als vrijwilliger</h1>
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

                    {!! Form::open() !!}

                        {!!Form::label('name','Naam')!!}
                        {!!Form::text('name',null,['required'=>''])!!}

                        {!!Form::label('first_name','Voornaam')!!}
                        {!!Form::text('first_name',null,['required'=>''])!!}

                        {!!Form::label('email','Email')!!}
                        {!!Form::email('email',null,['required'=>''])!!}

                        {!!Form::label('phone','Telefoonnummer')!!}
                        {!!Form::text('phone',null)!!}

                        {!!Form::label('mobile','Gsm-nummer')!!}
                        {!!Form::text('mobile',null)!!}

                        {!!Form::label('linked_participant','Naam van deelnemer aan wie je gelinkt bent (indien van toepassing)')!!}
                        {!!Form::text('linked_participant',null)!!}

                        {!!Form::label('whereabouts','Verblijf in Frankrijk (adres + naam hotel/b&b/camping)')!!}
                        {!!Form::textarea('whereabouts',null,['required'=>''])!!}

                        <div class="columns small-12 medium-6">
                            <button class="red rounded small" type="submit">Gegevens doorsturen</button>
                        </div>

                    {!! Form::close() !!}              
                        <div class="columns small-12 medium-6">
                            <a href="{{ url('/p/vrijwilliger') }}"><button class="red rounded small">Terug</button></a>
                        </div>

                </div>
            </div>
        </div>
    </div>

@stop