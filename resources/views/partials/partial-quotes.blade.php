<div class="row">

    <div class="columns small-12 medium-10 large-8 medium-centered">
        <h3 class="color-darkblue flamenco text-center">{{$quotes['title']}}</h3>
    </div>

    @if($quotes['show_cta'])
        <div class="columns small-12 medium-8 large-7 large-offset-1 text-center color-darkblue lato">
            @include('partials.partial-singlequote')
        </div>

        <div class="columns small-12 medium-4 large-3 end">
            <a href="{{$quotes['cta_btn_href']}}" class="button rounded blue block large">
                {!! $quotes['cta_btn_lbl'] !!} </a>
        </div>
    @else
        <div class="columns small-12 medium-12 large-10 large-offset-1 text-center color-darkblue lato end">
            @include('partials.partial-singlequote')
        </div>
    @endif
</div>