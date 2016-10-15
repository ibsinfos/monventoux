<!DOCTYPE html>
<html ng-app="monventoux" detection-classes scroll resize>

<head>
    <meta charset="utf-8">
    <meta name="google-site-verification" content="YLslxr8Mc2_ThLEFo8akKYTpOXLW7nCnC4406DzTFdU" />
    @if(isset($title))
        <title>Mon Ventoux 2016 | {{$title}}</title>
    @else
        <title>Mon Ventoux 2016</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">

    <script>
        var baseurl = "{{url('/')}}";
    </script>

    <link rel="apple-touch-icon-precomposed" href="{{asset('assets/ux/touch.png')}}">
    <link rel="icon" href="{{asset('assets/ux/favicon.ico')}}">

    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','//connect.facebook.net/en_US/fbevents.js');

        fbq('init', '1503358649963903');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1503358649963903&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->


</head>
<body class="{{$bodyclass}}">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if(d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.5&appId=1631895183747876";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<section class="page-content">

    <header id="logoheader">
        <a href="{{url('/')}}" id="logo-gold" class="">Mon Ventoux</a> <a href="{{url('/')}}" id="sportalogo"
                                                                     class=" hide-for-medium-down" scrollfade>Sporta</a>
    </header>

    @yield('content')

    @include('partials.partial-footer')

    <script src="{{asset('js/vendor.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</section>
</body>
</html>
