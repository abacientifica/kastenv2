<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Ventas Kasten V2">
    <meta name="author" content="aba.com">
    <meta name="keyword" content="Sistema Inventario">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="img/favicon.png">

    <!--Definimos el usuario que va utilizar el loguin de pusher-->
    <meta name="userId" content="{{ Auth::check() ? Auth::user()->Usuario : ''}}">  
    <title>Kasten V2</title>
    <!-- Main styles for this application -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <header class="app-header navbar">
            <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
            <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
            <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav navbar-nav d-md-down-none">
                <li class="nav-item px-3">
                    <a class="nav-link" href="#">Escritorio</a>
                </li>
            </ul>
            
            <ul class="nav navbar-nav ml-auto">
                <notificacion :notifications="notifications" v-model="menu"></notificacion>
                <div class="menu-rigth" v-if="{{\Auth::check()}}">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="img/icono_aba.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                            <span class="d-md-down-none" >{{Auth::user()->Nombres}} </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header text-center">
                                <strong>Cuenta</strong>
                            </div>
                            <a class="dropdown-item" @click="menu=13" href="#"><i class="icon-wrench"></i>Configuración</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i> Cerrar sesión</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </div>
            </ul>
        </header>

        <div class="app-body">
            @if(Auth::check())
                @if(Auth::user()->Tipo == 1)
                    @include('plantilla.sidebaradministrador')
                @elseif(Auth::user()->Tipo == 2)
                    @include('plantilla.sidebarusuarioexterno')
                @else
                    @include('plantilla.sidebarusuario')
                @endif
            @endif
            <!-- Contenido Principal -->
            @yield('contenido')
            <!-- /Fin del contenido principal -->
        </div>

        
    </div>
    
    <!--Fin Contenido App-->
    <footer class="app-footer">
        <span><a href="http://www.aba.com/">Kasten V2</a> &copy; 2020</span>
        <span class="ml-auto">Desarrollado por <a href="http://www.aba.com/">Aba Cientifica</a></span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    
</body>

</html>