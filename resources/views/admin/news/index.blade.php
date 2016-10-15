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

                        <div class="columns small-12 medium-6">
                            <a href="nieuwsbeheer/create" class="button rounded blue tiny">Nieuw</a>
                        </div>
                        <br />
                    @if( count($newsitems) > 0 )
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th>Titel</th>
                                        <th>Intro</th>
                                        <th>Start</th>
                                        <th>Stop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($newsitems as $item)
                                        <tr>
                                            <td><a href="{{ url('/admin/nieuwsbeheer', $item->id) }}">{{ $item->title }}</a></td>
                                            <td>{{ substr($item->intro, 0, 50) }}...</td>
                                            <td>{{ $item->start }}</td>
                                            <td>{{ $item->end }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @else
                        Er zijn geen nieuwsitems gevonden.
                    @endif                    
                </div>
            </div>
        </div>
    </div>

@stop