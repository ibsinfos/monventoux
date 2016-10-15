<nav class="main-menu" togglemenu>
    <div class="list">
        <div class="logo hide-for-medium-down" scrollfade></div>
        <ul>
            @foreach($navigation as $menuitem)
                <li><a href="{{$menuitem['url']}}">{{$menuitem['label']}}</a></li>
            @endforeach
                <!--li><a href="{{url('/webshop/producten')}}">Outfit</a></--li-->
                {{--style="font-size:36px;font-family:'Comic Sans MS';color:magenta;"--}}
            <li>&nbsp;</li>
            @if(Auth::check())
                <li><a href="{{url('/home')}}">{{Auth::user()->username}}</a></li>
                @if(Auth::user()->bedrijf == 'Sporta Admin') 
                    <li><a href="{{url('/admin/mails')}}">Groepdeelnemers mailen</a></li> 
                    <li><a href="{{url('/inschrijven')}}">Inschrijven</a></li> 
                    <li><a href="{{url('/mediamanager')}}">Mediamanager</a></li>
                    <li><a href="{{url('/admin/nieuwsbeheer')}}">Nieuwsbeheer</a></li>
                    <li><a href="{{url('/admin/quotebeheer')}}">Quotebeheer</a></li>
                @endif
                <!--li><a href="{{url('/p/testdagen')}}">Testdagen</a></li-->
                <li><a href="{{url('/logout')}}">Uitloggen</a></li>
            @else
                <li><a href="{{url('/login')}}">Inloggen</a></li>
                <!--li><a href="{{url('/inschrijven')}}">Inschrijven</a></li-->
            @endif
        </ul>
    </div>
    <a class="button menu"><i class="fa fa-navicon"></i></a>

</nav>