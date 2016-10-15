<div class="row">

    <div class="columns small-12 medium-10 large-8 medium-centered">
        <h3 class="color-darkblue flamenco text-center">Onze partners</h3>
    </div>

    <div class="clearfix"></div>
    @foreach($partners['large'] as $partner)
        <div class="columns small-6 medium-2 large-2 {{$partner['extraclass']}}">
            <figure>
                <img src="{{url($partner['src'])}}" alt="{{$partner['name']}}" width="202" height="152">
            </figure>
        </div>
    @endforeach
    <hr class="clearfix"/>

    @foreach($partners['medium'] as $partner)
        <div class="columns small-5 medium-2 large-2 {{$partner['extraclass']}}">
            <figure>
                <img src="{{url($partner['src'])}}" alt="{{$partner['name']}}" width="202" height="152">
            </figure>
        </div>
    @endforeach
    <hr class="clearfix"/>

    @foreach($partners['small'] as $partner)
        <div class="columns small-4 medium-2 large-2 {{$partner['extraclass']}}">
            <figure>
                <img src="{{url($partner['src'])}}" alt="{{$partner['name']}}" width="202" height="152">
            </figure>
        </div>
    @endforeach

</div>