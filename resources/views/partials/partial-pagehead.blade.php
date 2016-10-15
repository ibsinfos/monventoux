<div class="row">
    <header class="page-head">
        @foreach($event['challenges'] as $challenge)
            <a href="{{$challenge['url']}}" class="{{$challenge['color']}} active button rounded small lato text-centered">{{$challenge['title']}}</a>
        @endforeach
    </header>
</div>