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

                        <div class="columns small-12 medium-6">
                            <a href="quotebeheer/create" class="button rounded blue tiny">Nieuw</a>
                        </div>
                        <br />
                    @if( count($quotes) > 0 )
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th>Naam</th>
                                        <th>Afbeelding</th>
                                        <th>Tekst</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotes as $quote)
                                        <tr>
                                            <td><a href="{{ url('/admin/quotebeheer', $quote->id) }}">{{ $quote->name }}</a></td>
                                            <td>{{ $quote->img }}</td>
                                            <td>{{ substr($quote->txt, 0, 50) }}...</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @else
                        Er zijn geen quotes gevonden.
                    @endif                    
                </div>
            </div>
        </div>
    </div>

@stop