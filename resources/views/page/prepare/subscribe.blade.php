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
                    <h1 class="color-darkblue flamenco text-center">Inschrijven</h1>
                </div>
            </div>
        </header>
        <div class="page-content">
            <div class="row">
                <div class="columns small-12 medium-8 large-6 medium-centered end">
                    <div class="columns small-12">
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
                    </div>
                    <div class="columns small-12">

                        {!! Form::open() !!}

                        <p>Heeft u een inschrijving voor Mon Ventoux 2016?</p>
                        <input type="radio" name="ismember" id="ismember_yes" value="1"
                               changeradio show="form_member_yes"
                               docheck="{{!is_null(old('ismember')) && (old('ismember') == '1')}}"
                               hide="form_member_no"/><label
                                for="ismember_yes">Ja</label> <input type="radio" name="ismember" id="ismember_no"
                                                                     value="0" changeradio
                                                                     docheck="{{!is_null(old('ismember')) && (old('ismember') == '0')}}"
                                                                     show="form_member_no"
                                                                     hide="form_member_yes"/><label
                                for="ismember_no">Nee</label>


                        {!!Form::hidden('route_id',$route->id)!!}

                        <div class="hide form_member_yes">
                            {!!Form::label('deelnemersnummer','Je Mon Ventoux lidnummer (vindt je terug op je lidkaart)')!!}
                            {!!Form::text('deelnemersnummer',old('deelnemersnummer'))!!}
                        </div>
                        <div class="hide form_member_no">
                            {!!Form::label('firstname','Voornaam')!!}
                            {!!Form::text('firstname',old('firstname'))!!}

                            {!!Form::label('lastname','Achternaam')!!}
                            {!!Form::text('lastname',old('lastname'))!!}

                            {!!Form::label('email','Email')!!}
                            {!!Form::email('email',old('email'))!!}

                            {!!Form::label('street','Straat en huisnummer')!!}
                            {!!Form::text('street',old('street'))!!}

                            {!!Form::label('postalcode','Postcode')!!}
                            {!!Form::text('postalcode',old('postalcode'))!!}

                            {!!Form::label('city','Woonplaats')!!}
                            {!!Form::text('city',old('city'))!!}

                            {!!Form::label('country','Country')!!}
                            {!!Form::select('country',$countries,'BE')!!}

                            {!!Form::label('dob','Geboortedatum (dd/mm/jjjj)')!!}
                            {!!Form::text('dob',old('dob'))!!}

                            {!!Form::label('gender','Geslacht')!!}
                            {!!Form::select('gender',$genders,'')!!}

                            {!!Form::label('phone','Gsm-nummer')!!}
                            {!!Form::text('phone',old('phone'))!!}
                        </div>

                        <p>Kies uw optie</p>

                        @foreach($route->options as $i=>$option)
                            <div>
                                <input type="radio" name="options" id="{{$option[$i]}}" value="{{$option->id}}"/> <label><strong>{{$option->name}}</strong> - {{$option->description}}
                                </label>
                            </div>
                        @endforeach

                        <div class="hide form_member_yes">
                            <button class="red rounded small submitbutton" type="submit">Nummer controleren</button>
                        </div>

                        <div class="hide form_member_no">
                            {!!Form::checkbox('algemenevoorwaarden','1',false,['id'=>'algemenevoorwaarden'])!!}
                            <label for="algemenevoorwaarden">Ik accepteer de <a
                                        href="{{ url('download/pdf/algemene-voorwaarden-2016.pdf') }}"
                                        target="_blank">algemene voorwaarden</a></label> <br>

                            {!!Form::checkbox('gedragscode','1',false,['id'=>'gedragscode'])!!}
                            <label for="gedragscode">Ik accepteer de <a
                                        href="{{ url('download/pdf/gedragscode-2016.pdf') }}"
                                        target="_blank">gedragscode</a></label> <br>
                            <button class="red rounded small submitbutton" type="submit">Versturen</button>
                        </div>

                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
