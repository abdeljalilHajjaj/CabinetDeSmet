<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}} "></script>
    <script src="{{asset('datepicker/locales/bootstrap-datepicker.fr.min.js')}} "></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js"></script>
    <script src="https://kit.fontawesome.com/9abede768c.js" crossorigin="anonymous"></script>
    <script src="{{ asset('fullcalendar/packages/core/main.min.js') }}" ></script>
    <script src="{{ asset('fullcalendar/packages/core/locales/fr.js') }}" ></script>
    
    <script src="{{ asset('fullcalendar/packages/google-calendar/main.min.js') }}" ></script>
    <script src="{{ asset('fullcalendar/packages-premium/timeline/main.min.js') }}" ></script>
    <script src="{{ asset('fullcalendar/packages-premium/resource-common/main.min.js') }}" ></script>
    <script src="{{ asset('fullcalendar/packages-premium/resource-timeline/main.min.js') }}" ></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{asset('datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
    <link href="{{asset('fullcalendar/packages/core/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('fullcalendar/packages-premium/resource-timeline/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('fullcalendar/packages-premium/timeline/main.min.css')}}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            
                <a style="font-size:0.9rem" class="navbar-brand" href="#">
                    {{ config('app.name', 'Laravel') }}
                </a>

                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    <a style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.ajouter.pat') }}">
                         Ajouter un Patient
                     </a>

                     <a style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.afficher.rdv') }}">
                         Liste des rendez-vous
                     </a>
                     <a  style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.afficher.prendre.rdv') }}">
                        Ajouter un rendez-vous
                     </a>
                     <a  style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.afficher.liste.patient') }}">
                        Liste patient
                     </a>

                     <a  style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.historique.rdv') }}">
                        Historique des rendez-vous
                     </a>

                     
                     <a  style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.patient.attente') }}">
                        Liste d'attente
                     </a>

                     <a  style="font-size:0.8rem" class="navbar-brand" href="{{ route('sec.agenda') }}">
                        Agenda
                     </a>

                     
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('secretaire')->user()->nom }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Se déconnecter') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        
                    </ul>
                </div>
            
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@yield('js')
</html>
