<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Mon Ventoux 2016</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">

    <base href="/">

    <link rel="apple-touch-icon-precomposed" href="assets/ux/touch.png">
    <link rel="icon" href="assets/ux/favicon.ico">

    <link rel="stylesheet" href="css/main.css">

</head>
<body>
<section class="page-content banner home">
<header>
    <a ui-sref="home" id="logo" class="">Mon Ventoux</a>
    <a ui-sref="home" id="sportalogo" class=" hide-for-medium-down">Sporta</a>
    <ul class="breadcrumbs">
        @if(Auth::check())
            <li><a href="/gebruiker">{{Auth::user()->username}}</a></li>
            <li><a href="/">Bulkinvoer mailen</a></li>
            <li><a href="/logout">Uitloggen</a></li>
        @else
            <li><a href="/login">Inloggen</a></li>
            <!--li><a href="/inschrijven">Inschrijven</a></li-->
        @endif
    </ul>
</header>


@yield('content')

<script src="js/vendor.min.js"></script>
<script src="js/main.js"></script>

</section>
</body>
</html>
