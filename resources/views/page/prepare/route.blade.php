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
                    <h1 class="color-darkblue flamenco text-center">{{$page->title}}</h1>
                    @if(isset($page->subtitle))
                        <h4 class="color-darkblue lato text-italic text-center">{{$page->subtitle}}</h4>
                    @endif
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    {!! $page->body !!}
                </div>

                <div class="columns small-12 medium-3 large-3">
                    @foreach($page->routes as $item)
                        @if($route->id == $item->id)
                            <a href="{{url($path.$item->id)}}" class="button darkblue tiny rounded"
                               style="margin-bottom:5px;width:100%">{{$item->name}}<br/>
                                <small>{{date('d-m-Y', strtotime($item->event_date))}}</small>
                            </a>
                        @else
                            <a href="{{url($path.$item->id)}}" class="button blue tiny rounded"
                               style="margin-bottom:5px;width:100%">{{$item->name}}<br/>
                                <small>{{date('d-m-Y', strtotime($item->event_date))}}</small>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="columns small-12 medium-6 large-7">
                    <h2>{{$route->name}}</h2>
                    <h6>{{$route->location}} - {{date('d-m-Y', strtotime($route->event_date))}}</h6>
                </div>
                <div class="columns hide-for-small-only medium-3 large-2">
                    @if($route->active_subscription == 1 && strtotime($route->subscription_until) > strtotime(date('Y-m-d H:i:s')))
                        <a href="{{url($subscribepath.$route->id)}}"
                           class="rounded small-12 red small button columns">Inschrijven</a>
                    @endif
                    @if(!empty($route->pdflink))
                        <a href="{{$route->pdflink}}" class="rounded small-12 blue tiny button columns"
                           style="margin-top:5px;"
                           target="_blank">PDF</a>
                    @endif
                    @if(!empty($route->gpxlink))
                        <a href="{{$route->gpxlink}}" class="rounded small-12 blue tiny button columns"
                           style="margin-top:5px;"
                           target="_blank">GPX</a>
                    @endif
                </div>
                <div class="columns small-12 medium-9 large-9 end">
                    <hr/>
                    {!! $route->body !!}
                </div>
                <div class="columns hide-for-medium-up small-12">
                    @if(!empty($route->pdflink))
                        <a href="{{$route->pdflink}}" class="rounded small-12 blue tiny button columns"
                           style="margin-top:20px;" target="_blank">PDF</a>
                    @endif
                    @if(!empty($route->gpxlink))
                        <a href="{{$route->gpxlink}}" class="rounded small-12 blue tiny button columns"
                           style="margin-top:20px;" target="_blank">GPX</a>
                    @endif
                    @if($route->active_subscription == 1)
                        <a href="{{url($subscribepath.$route->id)}}" class="rounded small-12 red small button columns"
                           style="margin-top:20px;">Inschrijven</a>
                    @endif
                </div>

            </div>
        </div>
    </div>

@stop