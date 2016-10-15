<div class="row">

	@if($banner['href'])
	<a href="{{ $banner['href'] }}">
	@endif
   		<img src="{{$banner['img']}}"/>
	@if($banner['href'])
	</a>
	@endif

</div>