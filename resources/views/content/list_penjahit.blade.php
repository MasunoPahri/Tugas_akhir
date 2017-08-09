@extends('base')

@section('subtitle')Daftar Semua Poryek @stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Telusuri Penjahit </h1>
    </div>
</div>
<br>
<div class="container">
    @foreach($tailors as $tailor)
        <div class="col-md-3 userlist">
            <div class="body">
                <div class="upper">
                    <p>Rattings</p>
                </div>
                <div class="main">
                    <div class="imgProfile">
                        <img src="{{ asset('/images/img1.png') }}" alt="">
                    </div>
                    <p id="username"> {{ $tailor->nama_user }} </p>
                    <p id="address">{{ $tailor->alamat }}</p>
                    <p id="phone">{{ $tailor->no_telp }}</p>
                    <p id="skills">
                        @foreach($tailor->skills as $skill)
                            <span id="itemSkill">{{ $skill->nama_skill }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="ctaBtn">
                <a href="/WEB/profile/{{ $tailor->id_user }}" class="btn-block">Lihat Profil</a>
            </div>
        </div>
        <div class="col-md-1"></div>
    @endforeach
</div>
@stop
