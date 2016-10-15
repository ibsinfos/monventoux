<footer class="mainfooter ready">
    <figure></figure>
    <div class="row">
        <div class="columns small-12 medium-10 large-8 medium-centered end">
            @foreach($footernavigation as $footernav)
                <ul>
                    @foreach($footernav as $menuitem)
                        <li><a href="{{$menuitem['url']}}">{{$menuitem['label']}}</a></li>
                    @endforeach
                </ul>
            @endforeach
            <ul>
                <li><a href="{{ url('/eventfotos') }}">Foto's</a></li>
                <li><a href="https://twitter.com/monventoux" target="_blank">Twitter</a></li>
                <li><a href="https://vimeo.com/monventoux" target="_blank">Vimeo</a></li>
                <li><a href="https://www.flickr.com/photos/mijnventoux/albums" target="_blank">Flickr</a></li>
                <li><a href="https://www.facebook.com/monventoux.be" target="_blank">Facebook</a></li>
                <li><a href="https://instagram.com/monventoux" target="_blank">Instagram</a></li>
            </ul>
        </div>

        <div class="columns small-12 brandline">
            <p class="lato text-italic color-white"><span class="monventoux">Mon Ventoux</span> is een organisatie van
                <a
                        href="http://www.sporta.be" target="_blank"><span class="sporta">Sporta</span></a></p>

            <p class="lato text-italic color-white address">Geneinde 2, 2260 Tongerlo,<br/>+32(0)14/53 95 75, info[at]monventoux.be<br/>Ondernemingsnummer: BE0410.709.381
            </p>
        </div>
    </div>
</footer>