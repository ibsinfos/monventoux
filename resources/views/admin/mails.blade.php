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
                        Groepsdeelnemers mailen
                    </h1>
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

                    @if( count($users) > 0 )
                        {!! Form::open() !!}
                            <table>
                                <thead>
                                    <tr>
                                        <th>Bedrijf</th>
                                        <th>Naam</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->bedrijf }}</td>
                                            <td>{{ $user->voornaam . ' ' . $user->naam }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{!! Form::checkbox('sendMail[]',$user->sadn_id, true) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="columns small-12 medium-6">
                                <button type="submit" class="red rounded small">Mails versturen</button>
                            </div> 
                        {!! Form::close() !!}
                    @else
                        Er zijn geen groepsdeelnemers die nog geen logincodes hebben ontvangen.
                    @endif                    
                </div>
            </div>
        </div>
    </div>

@stop