<div class="row">
    <header class="page-head">
        @foreach($event['challenges'] as $challenge)
            <a href="{{$challenge['url']}}" class="{{$challenge['color']}} {{$challenge['class']}} button rounded small lato text-centered">{{$challenge['title']}}</a>
        @endforeach
    </header>
</div>