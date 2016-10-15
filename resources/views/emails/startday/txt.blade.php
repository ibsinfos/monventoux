Hoi {{$name}},

We hebben je aanmelding voor de startdag ontvangen.
<br/>Mocht er een fout zijn gemaakt. Laat het dan zo snel mogelijk weten via info@monventoux.be.

====================================
De door jou gekozen opties:
====================================

@foreach($options as $option)
    * {{$option}}
@endforeach

------------------------------------

====================================
De adressen van onze locaties:
====================================

@foreach($locations as $location)
    * {{$location['date']}}
    {{$location['name']}}
    {{$location['address']}}
    {{$location['city']}}

@endforeach
------------------------------------

Tot ziens op {{$chosendate}}!
