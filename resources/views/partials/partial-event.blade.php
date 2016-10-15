<div class="row">

    <div class="columns small-12 medium-10 large-8 medium-centered">
        <h3 class="color-darkblue flamenco text-center">{{$event['title']}}</h3>
        <a href="{{$event['subtitle_url']}}"><h6 class="lato text-italic color-darkblue text-center">{{$event['subtitle']}}</h6></a>
    </div>

    <div class="columns small-12 medium-12 large-9 large-centered end">

        @foreach($event['challenges'] as $challenge)

        <div class="columns small-12 medium-4">
            <a href="{{$challenge['url']}}" class="button {{$challenge['color']}} rounded small lato text-centered">{{$challenge['title']}}
                <small>{{$challenge['distance']}}</small>
            </a>
        </div>

        @endforeach

    </div>
</div>