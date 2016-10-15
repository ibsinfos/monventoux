<div class="row"><a name="keep-me-posted"></a>

    <div class="columns small-12 medium-10 large-8 medium-centered">
        <h3 class="color-darkblue flamenco text-center">Blijf op de hoogte</h3>
        <h6 class="lato text-italic color-darkblue text-center"></h6>
    </div>


    <div class="columns small-12 medium-10 large-8 medium-centered">
        <div class="button rounded social facebook small">
            <i class="fa fa-facebook"></i> Facebook
            <div class="fb-like" data-href="https://www.facebook.com/monventoux.be?fref=ts" data-width="200px"
                 data-layout="button_count"
                 data-action="like" data-show-faces="false" data-share="false"></div>
        </div>
        <div class="button rounded small social twitter">
            <i class="fa fa-twitter"></i> Twitter <a href="https://twitter.com/monventoux" class="twitter-follow-button"
                                                     data-show-count="false" data-lang="nl">Volg @monventoux</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if(!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
        </div>
        @if(isset($vimeo) && $vimeo)
            <a href="#" target="_blank" class="button social vimeo rounded blue small">
                <i class="fa fa-vimeo"></i> Vimeo
            </a>
        @endif
    </div>

    <div class="columns small-12 medium-10 large-10 medium-centered ">
        <p id="newslettermessage" class="lato color-darkblue">Laat hier je e-mailadres achter en krijg 1 keer per maand gratis tips voor betere klimmersbenen.</p>
    </div>
    <div id="form" class="columns small-12 medium-10 large-8 medium-centered">
        <form method="post" newsletterform ng-controller="NewsletterController">
            <input type="hidden" value="{{csrf_token()}}" name="_token" ng-model="formdata._token"/> <input type="email"
                                                                                                            placeholder="jouw@emailadres.be"
                                                                                                            value=""
                                                                                                            name="email"
                                                                                                            ng-model="formdata.email"/>
            <button type="submit" class="blue lato text-italic text-center medium rounded submitbutton">
                Verstuur
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
        </form>
    </div>
</div>