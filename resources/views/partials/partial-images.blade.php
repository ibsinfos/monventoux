<div ng-controller="ImagesController">
    <div class="overlay">

        <div class="container">
            @foreach($mediadata as $mediaitem)
                <figure>
                    <a href="{{$mediaitem['large']}}" media-item type="{{$mediaitem['type']}}"> <img src="{{$mediaitem['small']}}" alt="{{$mediaitem['alt']}}"/> </a>
                </figure>
            @endforeach
        </div>

    </div>

    <div class="media-overlay hide video image" media-overlay>
        <img src="" width="100%" height="100%">
        <iframe src="" width="100%"
                height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        <a ng-click="closeOverlay()" class="close">Close</a>
    </div>
</div>