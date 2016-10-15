<figure class="quoteimg">
    @if($quotes['quote']['img'] == '')
        <img src="{{ asset('assets/img/no-picture.png') }}"/>
    @else
        <img src="{{ asset($quotes['quote']['img']) }}"/>
    @endif

    <div class="text">
        <h6 class="flamenco color-darkblue">{{$quotes['quote']['name']}}</h6>
        <p>{{$quotes['quote']['age']}}</p>
    </div>
</figure>
<p>{{$quotes['quote']['txt']}}</p>