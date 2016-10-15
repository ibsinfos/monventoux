<div class="row">

    <div class="columns small-12 medium-10 large-8 medium-centered">
        <h3 class="color-darkblue flamenco text-center">{{$eventday['title']}}</h3>
        <a href="{{$eventday['subtitle_url']}}"><h6 class="lato text-italic color-darkblue text-center">{{$eventday['subtitle']}}</h6></a>
    </div>

    <div class="columns small-12 medium-8 large-5 medium-centered end">

        @foreach($eventday['buttons'] as $button)

        <div class="columns small-24 medium-12">
            <a href="{{$button['url']}}" class="button {{$button['color']}} rounded small lato text-centered">{{$button['title']}}</a>
        </div>

        @endforeach

    </div>
</div>