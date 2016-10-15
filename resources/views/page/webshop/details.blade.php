@extends('main')

@section('content')

    <figure class="banner fixed page">
    </figure>
    @include('partials.partial-pagehead')
    @include('partials.partial-menu')

    <div class="page-sections">
        <header class="page-header">
            <div class="row">
                <div class="columns small-12 medium-10 large-8 medium-centered end">
                    <h1 class="color-darkblue flamenco text-center">Mon Ventoux-outfit</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div style="text-align: center;margin-bottom:50px;">

                <div class="columns small-12 medium-8 large-6 small-centered">
                    <p>Let op! De outfit is enkel nog in Frankrijk te verkrijgen tijdens de incheck in Bédoin op vrijdag 17 juni tussen 10 en 18 uur.</p>
                </div>
                    <!--div class="columns small-12 medium-8 large-6 small-centered">
                        <a href="{{ url('/webshop/bestellen') }}">
                            <button class="red rounded small">Bestelling aanvragen</button>
                        </a>
                    </div-->
                </div>
                <div class="columns small-12 medium-8 large-6 medium-centered end">
                    <div class="columns small-5 small-offset-1"><img
                                src="{{ url('assets/img/webshop/mv-outfit-front.jpg') }}"/></div>
                    <div class="columns small-5 end"><img src="{{ url('assets/img/webshop/mv-outfit-back.jpg') }}"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="columns small-12 large-10 large-centered end" style="margin-top: 50px;">
                    <div class="columns small-12 medium-8">
                        <h4>Prof Jersey Bodyfit (trui korte mouwen)</h4>

                        <p>De Prof Jersey Bodyfit trui met korte mouwen is op de super competitieve Race Proven trui gebaseerd. Het aero- en athletic fit design zijn daarvan de belangrijkste elementen. Hierdoor wordt dit shirt ook erg gewaardeerd door competitieve fietsers. Een perfect uitgekiende bodyfit snit met aeroshape mouwen en het daaraan verbonden draagcomfort is voor deze fietscategorie dan ook van zeer groot belang. Door voor dit zomershirt van een optimaal ventilerend UV beschermend stof gebruik te maken is het ook zeer snel droog. Voorzien van drie achterzakken en afgewerkt met een lange vergrendelbare rits.</p>
                        <p>Prijs: &euro;&nbsp;45,00<br>Korting CM-leden: &euro;&nbsp;3,00</p>
                    </div>
                    <div class="columns small-12 medium-4">
                        <img src="{{ url('assets/img/webshop/shirt_shortsleeves.jpg') }}"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="columns small-12 large-10 large-centered end" style="margin-top: 50px;">
                    <div class="columns hide-for-small-down medium-4">
                        <img src="{{ url('assets/img/webshop/shirt_longsleeves.jpg') }}"/>
                    </div>
                    <div class="columns small-12 medium-8">
                        <h4>Jersey LS Prof Isolation (trui lange mouwen)</h4>

                        <p>Het voor de Isolation trui met lange mouwen gebruikte textiel heeft een hoge isolatiewaarde waardoor het lichaam zijn ideale temperatuur beter kan behouden. Daarnaast heeft dit stof optimale ventilerende- en transpiratievocht afvoerende eigenschappen met als gevolg dat het shirt ook steeds goed droog blijft. Dit alles maakt dat deze aangenaam zacht aanvoelende Isolation trui met lange mouwen, zelfs bij frissere temperaturen, comfortabel en licht om te dragen is. Voorzien van drie achterzakken en een lange vergrendelbare rits. Als optie kan een ritszak op de rug worden geplaatst.</p>
                        <p>Prijs: &euro;&nbsp;59,00<br>Korting CM-leden: &euro;&nbsp;3,00</p>
                    </div>
                    <div class="columns hide-for-medium-up small-12">
                        <img src="{{ url('assets/img/webshop/shirt_longsleeves.jpg') }}"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="columns small-12 large-10 large-centered end" style="margin-top: 50px;">
                    <div class="columns small-12 medium-8">
                        <h4>Professional Body Windblock</h4>

                        <p>Deze mouwloze Bioracer Body is uit het lichtgewicht Windblock stof vervaardigd. Dit elastische stof blokt wind af, is waterafstotend en houdt de lichaamstemperatuur goed op peil. Door zijn lichtgewicht structuur is de body klein op te vouwen en zo makkelijk als extra kleding in de achterzak van een trui mee te nemen. Voorzien van een lange vergrendelbare rits.</p>
                        <p>Prijs: &euro;&nbsp;64,00<br>Korting CM-leden: &euro;&nbsp;5,00</p>
                    </div>
                    <div class="columns small-12 medium-4">
                        <img src="{{ url('assets/img/webshop/windblock.jpg') }}"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="columns small-12 large-10 large-centered end" style="margin-top: 50px;">
                    <div class="columns hide-for-small-down medium-4">
                        <img src="{{ url('assets/img/webshop/short_male.jpg') }}"/>
                    </div>
                    <div class="columns small-12 medium-8">
                        <h4>Bibshort Prof Lycra (broek heren)</h4>

                        <p>De klassiek voor koersbroeken gebruikte elastische textielsoort Lycra garandeert een optimaal draagcomfort. Bij een nauwkeurige opvolging van de onderhoudsvoorschriften biedt deze Bioracer koersbroek in Lycra uitvoering veel fietsplezier. Om de korte broek steeds goed op haar plaats te houden zijn de broekspijpen met een speciale irritatie voorkomende antislip boord afgewerkt. Ook wordt de broek door de uit elastisch Eyelet stof gemaakte bretellen goed opgehouden en laat toe om in alle vrijheid te bewegen. Met dubbel gevoerd achterste broekpand en centraal op de rug van een zender-, gsm- of MP3 zakje voorzien. Een uitzonderlijke afwerkingskwaliteit gekoppeld aan een maximale bewegingsvrijheid zijn voor beide broekuitvoeringen de meest belangrijke eigenschappen.</p>
                        <p>Prijs: &euro;&nbsp;52,00<br>Korting CM-leden: &euro;&nbsp;3,00</p>
                    </div>
                    <div class="columns hide-for-medium-up small-12">
                        <img src="{{ url('assets/img/webshop/short_male.jpg') }}"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="columns small-12 large-10 large-centered end" style="margin-top: 50px;">
                    <div class="columns small-12 medium-8">
                        <h4>Short Sport Lycra (broek dames)</h4>

                        <p>De klassiek voor koersbroeken gebruikte elastische textielsoort Lycra garandeert een optimaal draagcomfort. Bij een nauwkeurige opvolging van de onderhoudsvoorschriften biedt deze Bioracer koersbroek in Lycra uitvoering veel fietsplezier. Om deze korte fietsbroek steeds goed op haar plaats te houden zijn de broekspijpen met een speciale irritatie voorkomende antislip boord afgewerkt. Voor extra slijtvastheid is het achterste broekpand dubbel gevoerd. Een uitzonderlijke afwerkingskwaliteit gekoppeld aan een maximale bewegingsvrijheid zijn voor beide stofuitvoeringen de meest belangrijke eigenschappen.</p>
                        <p>Prijs: &euro;&nbsp;52,00<br>Korting CM-leden: &euro;&nbsp;3,00</p>
                    </div>
                    <div class="columns small-12 medium-4">
                        <img src="{{ url('assets/img/webshop/short_female.jpg') }}"/>
                    </div>
                </div>
            </div>
            <div style="padding-top: 50px;padding-bottom: 50px;text-align: center;">

                <!--div class="columns small-12 medium-8 large-6 small-centered">
                    <a href="{{ url('/webshop/bestellen') }}">
                        <button class="red rounded small">Bestelling aanvragen</button>
                    </a>
                </div-->
            </div>
        </div>
    </div>
    </div>

@stop