<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menjarum | @yield('subtitle')</title>
	<link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/main-style.css') }}">
	<link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="main-wrapper">
        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/WEB/">Menjarum</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    @if( $sess == "penjahit" )
                    <ul class="nav navbar-nav">
                        <li><a href="/WEB/allProjects">Telusiri Proyek </a></li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav">
                        <li><a href="/WEB/tailors">Telusiri Penjahit </a></li>
                        <li><a href="/WEB/portofolio-search/all">Cari Portofolio </a></li>
                    </ul>
                    @endif
                    
                    <ul class="nav navbar-nav navbar-right">
                        @if( $sess == "konsumen" )
                        <li class="active"><a href="/WEB/project/new">+ Proyek Baru</a></li>
                        <li><a href="/WEB/dasbor/{{ $sess }}">Beranda</a></li>
                        @elseif( $sess == "penjahit" )
                        <li><a href="/WEB/projects/{{ $user }}">Proyek Saya</a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $user }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/WEB/profile/{{ $user }}">Profil</a></li>
                                @if( $sess == "penjahit" )
                                <li>
                                    <a href="/WEB/portofolio/list">Portofolio</a>
                                </li>
                                @elseif( $sess == "konsumen" )
                                <li>
                                    <a href="/WEB/invoice/list">Pembayaran</a>
                                </li>
                                @endif
                                <li role="separator" class="divider"></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>

    <div class="container">
        @yield('content')
        <div class="spaceBlock"></div>
    </div>

    <script src=" {{ URL::to('bootstrap/js/jquery-2.0.2.min.js') }} "></script>
    <script src=" {{ URL::to('bootstrap/js/bootstrap.min.js') }} "></script>
    <script src=" {{ URL::to('js/main.js') }} "></script>
</body>
</html>