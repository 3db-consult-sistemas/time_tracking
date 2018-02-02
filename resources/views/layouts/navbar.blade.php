<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                3dB Consult
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar-->
            <ul class="nav navbar-nav">
                @auth
                    <li><a href="{{ url('/summary') }}">Resumen</a></li>
                    @if(Gate::check('checkrole', 'super_admin') || Gate::check('checkrole', 'admin'))
                        <li><a href="{{ url('/reports') }}">Reportes</a></li>

                        @if (isset($openTickets) && $openTickets > 0)
                            <li><a href="{{ url('/tickets') }}">Tickets <span class="badge">{{ $openTickets }}</span></a></li>
                        @else
                            <li><a href="{{ url('/tickets') }}">Tickets</a></li>
                        @endif

                        <li><a href="{{ url('/users') }}">Usuarios</a></li>
                    @endif
                    <li><a href="{{ url('/help') }}">Ayuda</a></li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else

                    @if(Gate::check('checkrole', 'super_admin') || Gate::check('checkrole', 'admin'))
                        <li><a href="{{ url('/getIp') }}">Obtener IP</a></li>
                    @endif

                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    -->
                @endguest
            </ul>
        </div>
    </div>
</nav>
