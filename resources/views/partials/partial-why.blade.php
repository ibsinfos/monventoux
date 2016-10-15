<div class="row">

    <div class="columns small-12 medium-10 large-8 medium-centered">
        <h3 class="color-darkblue flamenco text-center">{{$why['title']}}</h3>
    </div>

    <div class="columns small-12 medium-11 large-9 medium-centered">

        <div class="columns small-12 medium-6 large-4 color-darkblue lato">
            <img src="{{asset('assets/img/icons/1.png')}}">
            <p>Profiteer van <strong>12 jaar ervaring</strong> en een tevredenheidsscore van 8,9. <br/>
                @if ($why['url1'] <> '#') <a href="{{$why['url1']}}">Lees meer</a> @endif
            </p>
        </div>
        <div class="columns small-12 medium-6 large-4 color-darkblue lato">
            <img src="{{asset('assets/img/icons/2.png')}}">
            <p><strong>Wereldberoemd.</strong><br/>Overwin 1 van de meest mythische cols ter wereld. <br/>
                @if ($why['url2'] <> '#') <a href="{{$why['url2']}}">Lees meer</a> @endif
            </p>
        </div>
        <div class="clearfix hide-for-large-up"></div>
        <div class="columns small-12 medium-6 large-4 color-darkblue lato">
            <img src="{{asset('assets/img/icons/3.png')}}">
            <p>Beginnende, sportieve of ervaren fietser? Krijg een <strong>op-jouw-lijf-geschreven</strong> uitdaging.<br/>
                @if ($why['url3'] <> '#') <a href="{{$why['url3']}}">Lees meer</a> @endif
            </p>
        </div>
        <div class="clearfix hide-for-medium-down"></div>
        <div class="columns small-12 medium-6 large-4 color-darkblue lato">
            <img src="{{asset('assets/img/icons/4.png')}}">
            <p>Onmogelijk? Onze campagne stuwt
                <strong>meer dan 97%</strong> naar het dak van een prachtig maanlandschap.<br/>
                @if ($why['url4'] <> '#') <a href="{{$why['url4']}}">Lees meer</a> @endif
            </p>
        </div>
        <div class="clearfix hide-for-large-up"></div>
        <div class="columns small-12 medium-6 large-4 color-darkblue lato">
            <img src="{{asset('assets/img/icons/5.png')}}">
            <p>Ontdek de adembenemende Provence tijdens de toeristische opwarmingsritten van La Vintoux. <br/>
                @if ($why['url5'] <> '#') <a href="{{$why['url5']}}">Lees meer</a> @endif
            </p>
        </div>
        <div class="columns small-12 medium-6 large-4 color-darkblue lato">
            <img src="{{asset('assets/img/icons/6.png')}}">
            <p>Steun het Postrevalidatiecentrum To Walk Again en help mensen met een fysieke beperking opnieuw te stappen.<br/>
                @if ($why['url6'] <> '#') <a href="{{$why['url6']}}">Lees meer</a> @endif</p>
            </p>
        </div>

    </div>
</div>