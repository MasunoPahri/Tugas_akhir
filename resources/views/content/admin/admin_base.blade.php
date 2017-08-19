<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menjarum | @yield('subtitle')</title>
	<link rel="stylesheet" href="{{ asset('/css/main-style.css') }}">
	<link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
</head>
<body class="admin">
    <div class="main-wrapper">
        <div class="sidemenu col-md-2">
            <div class="dimBG">
                <div class="brandName">
                    <p>menjarum</p>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="/adminpanel/home">Beranda</a></li>
                        <li><a href="/adminpanel/users">Pengguna</a></li>
                        <li><a href="/adminpanel/testimonials/view">Testimonial</a></li>
                        <li><a href="/adminpanel/bills">Pembayaran</a></li>
                        <li><a href="/adminpanel/reports">Laporan Konsumen</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="rightside col-md-10">
            <div class="navbar">
                <div class="col-md-6">
                    <div class="pull-left page">
                        <p>@yield('pageTitle')</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right ctrl">
                        <div class="item">
                            <a href="/adminpanel/profile/@yield('username')">Profile</a>
                            <a href="/logout">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contentCov">
                <div class="col-md-12">
                    @yield('content')
                </div>
            </div>
        </section>
    </div>

    <script src=" {{ URL::to('bootstrap/js/jquery-2.0.2.min.js') }} "></script>
    <script src=" {{ URL::to('bootstrap/js/bootstrap.min.js') }} "></script>
    <script src=" {{ URL::to('js/main.js') }} "></script>
</body>
</html>