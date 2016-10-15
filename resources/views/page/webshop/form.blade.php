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
                    <h1 class="color-darkblue flamenco text-center">Bestel uw outfit</h1>
                </div>
            </div>
        </header>
        <div class="page-content" ng-controller="WebshopController">
            <div class="row">
                <div class="columns small-12 large-7">
                    <p>De outfit is enkel nog in Frankrijk te verkrijgen tijdens de incheck in Bédoin op vrijdag 17 juni tussen 10 en 18 uur.</p>
                </div>
            </div>
            <!--
            <form action="{{url('/webshop/verstuur')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="row">
                    <div class="columns small-12 large-7">

                        @if(isset($errors))
                            <div>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(Session::has('status'))
                            <div>
                                <p>{{ Session::get('status') }}</p>
                            </div>
                        @endif

                        <h4>Geef je gewenste items, maten en aantallen op</h4>

                        <div class="shoplist">
                            @foreach($products as $product)
                                <div class="item columns small-12">
                                    <h5 class="columns small-12">{{$product['name']}}</h5>
                                    <input type="hidden"
                                           id="product-name{{$product['id']}}"
                                           value="{{$product['name']}}"
                                           ng-model="items.name[{{$product['id']}}]"/>

                                    @if($members)
                                        {{--// Not used yet--}}
                                        <input type="hidden" id="product-price{{$product['id']}}"
                                               value="{{$product['prices'][1]}}"
                                               ng-model="items.price[{{$product['id']}}]"/>
                                    @else
                                        <input type="hidden" id="product-price{{$product['id']}}"
                                               value="{{$product['prices'][0]}}"
                                               ng-model="items.price[{{$product['id']}}]"/>
                                        <input type="hidden" id="product-discount{{$product['id']}}"
                                               value="{{$product['discount']}}"
                                               ng-model="items.discount[{{$product['id']}}]"/>
                                    @endif

                                    <div class="columns small-6 medium-3">
                                        <input ng-model="items.count[{{$product['id']}}]" type="text" value="0"
                                               onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                    </div>
                                    <div class="columns small-6 medium-3">
                                        <select ng-model="items.size[{{$product['id']}}]">
                                            @foreach($product['sizes'] as $size)
                                                <option value="{{$size}}">{{$size}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="columns small-6 medium-3">
                                        @if(count($product['genders']) > 1)
                                            <select ng-model="items.gender[{{$product['id']}}]">
                                                @foreach($product['genders'] as $gender)
                                                    <option value="{{$gender}}">{{$gender}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" disabled="disabled"
                                                   ng-model="items.gender[{{$product['id']}}]"
                                                   value="{{$product['genders'][0]}}">
                                        @endif
                                    </div>
                                    <div class="columns small-6 medium-3">
                                        <a class="red small rounded button"
                                           ng-click="add({{$product['id']}})">Toevoegen </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <aside class="columns small-12 large-5 cartlist">
                        <h4 style="padding-left: 15px;">Bestellen</h4>

                        <h5 style="padding-left: 15px;padding-top:15px;">Persoonlijke gegevens</h5>

                        <div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <input type="text" name="firstname" placeholder="Voornaam" value="" required>
                        </div>
                        <div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <input type="text" name="lastname" placeholder="Achternaam" value="" required>
                        </div>
                        <div class="columns small-7 medium-8 large-8 basket-list form-field">
                            <input type="text" name="street" placeholder="Straatnaam" value="" required>
                        </div>
                        <div class="columns small-5 medium-4 large-4 basket-list form-field">
                            <input type="text" name="number" placeholder="Huisnummer" value="" required>
                        </div>
                        <div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <input type="text" name="postalcode" placeholder="Postcode" value="" required>
                        </div>
                        <div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <input type="text" name="city" placeholder="Plaatsnaam" value="" required>
                        </div>
                        <div class="columns small-12 medium-12 large-12 basket-list form-field">
                            <input type="text" name="country" placeholder="Land" value="">
                        </div>
                        <div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <input type="text" name="phone" placeholder="Telefoon" value="">
                        </div>
                        <div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <input type="email" name="emailaddress" placeholder="E-mailadres" value="" required>
                        </div>

                        <div class="columns small-12 medium-12 large-12 basket-list form-field">
                            <label><h6 style="padding-left: 15px;">Ophalen of verzenden?</h6></label> <select
                                    name="collectlocation" ng-model="collectlocation" ng-change="changelocation()"
                                    required>
                                <option value="tongerlo" selected="selected">Sporta Centrum Tongerlo</option>
                                <option value="mvdag">Monventoux dag</option>
                                <option value="send">Thuisbezorgen (€8,-)</option>
                            </select> <input type="hidden" name="sendcost" value="0"
                                             ng-value="collectlocation == 'send' ? 8 : 0">
                        </div>

                        <!--div class="columns small-12 medium-6 large-6 basket-list form-field">
                            <label class="checkboxlabel"><input type="checkbox" value="memberdata"
                                                                ng-model="memberdata"> Bent u CM Lid?</label>
                        </div>
                        <div class="columns small-12 medium-6 large-6 basket-list form-field hide" ng-show="memberdata">
                            <input type="text" name="membernumber" ng-model="membercode"
                                   placeholder="CM Lidmaatschapsnummer" value="">
                        </div-->

            <!--
                        <div class="clearfix"></div>
                        <h5 style="padding-left: 15px;padding-top:15px;">Geselecteerde producten</h5>

                        <p style="padding-left: 15px;" class="basket-list"
                           ng-show="products.length == 0">Nog geen product geselecteerd</p>

                        <ul ng-show="products.length > 0" class="basket-list hide">
                            <li ng-repeat="(index,product) in products">
                                <input type="hidden" name="products[{[{index}]}]"
                                       value="{{json_encode(['{[{product.name}]}','{[{product.gender}]}','{[{product.size}]}','{[{product.count}]}','{[{product.price}]}','{[{product.discount}]}'])}}">
                                <input type="hidden" name="amount"
                                       value="{[{totalprice}]}"> <input type="hidden" name="subamount"
                                                                        value="{[{subtotalprice}]}"> <input
                                        type="hidden" name="discount"
                                        value="{[{discount}]}">
                            <span class="columns small-12 hide-for-medium-up">{[{product.name}]} <a
                                        class="right tiny red rounded button"
                                        remove-item-button data-index="{[{product.index}]}">Verwijderen </a></span>
                            <span class="columns small-9 hide-for-medium-up">{[{product.gender}]} Maat: {[{product.size}]} <span
                                        class="count">{[{product.count}]}</span></span>
                            <span
                                    class="columns hide-for-small-only medium-3 large-4 basket-column basket-name">{[{product.name}]}</span> <span
                                        class="columns hide-for-small-only medium-2 large-2 basket-column basket-gender">{[{product.gender}]}</span> <span
                                        class="columns hide-for-small-only medium-2 large-1 basket-column basket-size">{[{product.size}]}</span>
                            <span class="columns hide-for-small-only medium-1 basket-column basket-count">
                                <span class="count">{[{product.count}]}</span>
                            </span> <span
                                        class="columns small-3 medium-2 text-right basket-column basket-price">&euro;{[{product.price}]},-</span>
                            <span class="columns hide-for-small-only medium-2 basket-column basket-remove">
                                <a class="right tiny red rounded button"
                                   remove-item-button data-index="{[{product.index}]}">Verwijderen </a>
                            </span>
                            </li>
                        </ul>
                        <ul ng-show="products.length > 0" class="basket-list hide">
                            <li>
                                <span class="columns small-12 medium-5 medium-offset-3 text-right basket-column basket-total"><strong>Verzendkosten:</strong></span>
                                <span class="columns small-12 medium-2 end text-right basket-column basket-total">&euro;{[{sendcost}]},-</span>
                            </li>
                            <li class="basket-list hide">
                                <span class="columns small-12 medium-3 medium-offset-5 text-right basket-column basket-total"><strong>Subtotaal:</strong></span>
                                <span class="columns small-12 medium-2 end text-right basket-column basket-total">&euro;{[{subtotalprice}]},-</span>
                            </li>
                            <li class="basket-list hide">
                                <span class="columns small-12 medium-5 medium-offset-3 text-right basket-column basket-total"><strong>Korting:</strong></span>
                                <span class="columns small-12 medium-2 end text-right basket-column basket-total">&euro;{[{discount}]},-</span>
                            </li>
                            <li>
                                <span class="columns small-12 medium-3 medium-offset-5 text-right basket-column basket-total"><strong>Totaal:</strong></span>
                                <span class="columns small-12 medium-2 end text-right basket-column basket-total">&euro;{[{totalprice}]},-</span>
                            </li>
                        </ul>

                        <footer ng-show="products.length > 0" class="basket-list hide" style="padding-bottom: 100px;">
                            <button type="submit" class="small rounded" style="float:right;">Kopen</button>
                        </footer>

                    </aside>
                    <div ng-init="initBasket()"></div>
                </div>
            </form>
            -->
        </div>
    </div>
@stop