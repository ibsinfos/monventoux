<div class="columns small-12 medium-6 large-4 end">
    <div class="column-content-block">
        <h5 class="flamenco color-white">{{$news[0]['title']}}</h5>
        @unless($news[0]['picture'] == '')
            <img src="{{asset($news[0]['picture'])}}">
        @endunless
        <p class="lato color-white">{!! $news[0]['intro'] !!}</p>
        <a href="{!! url('/nieuws') !!}" class="button small white block color-blue rounded">Meer nieuws</a>
    </div>
</div>