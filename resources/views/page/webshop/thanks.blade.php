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
                    <h1 class="color-darkblue flamenco text-center">Bedankt voor je bestelling</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">
                    <h4>Dag {{$order->firstname}}</h4>

                    <p>Fijn dat je gekozen hebt voor een Mon Ventoux-outfit.<br/>Jouw bestelling:</p>
                    <ul>
                        @foreach($products as $product)
                            <li>{{$product['count']}}x {{$product['name']}}. {{$product['gender']}}, maat {{$product['size']}} </li>
                        @endforeach
                    </ul>

                    <h5>Vragen</h5>

                    <p>Wij zijn er om jou te helpen.</p>

                    <p><strong>E</strong> info@monventoux.be</p>

                    <p><strong>T</strong> 014 53 95 75</p>

                    <p><a href="{{url('/')}}" class="small button red" target="_self">Home</a></p>
                </div>
            </div>

        </div>
    </div>
@stop