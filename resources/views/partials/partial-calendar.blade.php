<div class="columns small-12 medium-6 large-6 large-offset-1">
    <div class="column-content-block">
        <h4 class="flamenco color-white">Nog {{$calendar['days']}} dagen tot Mon Ventoux.</h4>

        <ul class="calendar-list">
            @foreach($dates as $date)
                <li class="{{$date['class']}}">
                    <date>{{$date['date']}}</date>
                    @if($date['link'] == '')
                        <span>{{$date['label']}}</span>
                    @else
                        <span><a style="color: #ffffff;" href="{{$date['link']}}">{{$date['label']}}</a></span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>