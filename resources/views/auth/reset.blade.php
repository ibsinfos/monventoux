@extends('main')

@section('content')
        <!-- resources/views/auth/reset.blade.php -->

<figure class="banner fixed page">
</figure>
@include('partials.partial-pagehead')
@include('partials.partial-menu')

<div class="page-sections">
    <header class="page-header">
        <div class="row">
            <div class="columns small-12 medium-10 large-8 medium-centered end">
                <h1 class="color-darkblue flamenco text-center">Wijzig je wachtwoord</h1>
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
                            <p class="lato color-darkblue">{{ Session::get('status') }}</p>
                        </div>
                    @endif
                </div>

                {!! Form::open(['url'=>'/password/reset','class'=>'validator','novalidate'=>'']) !!}

                <div class="columns small-12">
                    <input type="hidden" name="token" value="{{ $token }}">

                    {!!Form::label('username','Gebruikersnaam')!!}
                    {!!Form::email('username',null,['required'=>'', 'autofocus'=>'', 'minlength'=>6])!!}

                    {!!Form::label('password','Paswoord',['class'=>'control-label col-sm-3 col-md-2'])!!}
                    {!!Form::password('password',['required' =>'' , 'minlength'=>6])!!}

                    {!!Form::label('password_confirmation','Paswoord confirmatie')!!}
                    {!!Form::password('password_confirmation',['class'=>'validator-equal-password','required' =>'' , 'minlength'=>6])!!}

                    <button class="red rounded small" type="submit">Opslaan</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 