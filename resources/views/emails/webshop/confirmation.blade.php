@extends('emails/layout')

@section('content')

<p>Beste {{ $order->firstname }},</p>

@if($order->send == 0)
    <p>De volgende producten liggen voor je klaar bij<br/><strong>{{$retrieve}}</strong></p>
@else
    <p>De volgende producten worden verzonden naar:<br/>
        <strong>{{$order->address}}<br/>
        {{$order->postalcode}}, {{$order->city}}<br/>
        {{$order->country}}</strong></p>
@endif
<ul>
    @foreach($products as $product)
        <li>{{$product['count']}}x {{$product['name']}}. {{$product['gender']}}, maat {{$product['size']}} </li>
    @endforeach
</ul>

@stop