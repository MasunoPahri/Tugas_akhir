@extends('base')

@section('subtitle') Lihat Profil @stop

@section('content')
@if (Session::has('report_abuse'))
<div class="alert alert-success">
    {{ Session::get('report_abuse') }}
</div>
@endif
<div class="col-md-12 profile-wrapper">
    <div class="col-md-3 leftside">
        <div class="upper">
            <div class="img-profile">
                <img src="{{ asset('/images') }}/{{ $userDetail->foto }}" alt="">
            </div>
            <div style="display:none">
            </div>
            @if($mode == "myProfile")
            <div class="ctaBtn-profile">
                <a href="#" data-toggle="modal" data-target=".uploadModal2"
                    class="btn btn-default btn-block">Ganti Foto</a>
                <a href="#" data-toggle="modal" data-target=".uploadModal3"
                    class="btn btn-default btn-block">Ubah Password</a>
            </div>
            @endif
        </div>
        @if($mode == "tailorProfile")
        <div class="bottom">
            <p><b>Daftar Skill</b></p>
            <ul>
                @foreach($userDetail->skills as $skill)
                    <li style="text-transform: capitalize;">{{ $skill->nama_skill }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-8 rightside">
        <div class="upper col-md-12">
            @if($mode == "tailorProfile")
                @if($jlhPenilai > 0)
                <div class="score pull-left">
                    <div id="title"> 
                        @if($index >= 0 && $index < 20)
                        <span class="label label-success">SANGAT BURUK</span>
                        @elseif($index >= 20 && $index < 40)
                        <span class="label label-success">BURUK</span>
                        @elseif($index >= 40 && $index < 60)
                        <span class="label label-success">BIASA</span>
                        @elseif($index >= 60 && $index < 80)
                        <span class="label label-success">BAGUS</span>
                        @elseif($index >= 80 && $index <= 100)
                        <span class="label label-success">SANGAT BAGUS</span>
                        @endif
                    </div>
                    <div id="body">{{ $index }}%</div>
                    <div id="bottom">
                        <span class="label label-info">{{ $jlhPenilai }} Konsumen</span>
                    </div>
                </div>
                @else
                <div class="score pull-left">
                    <div id="title"> 
                        <span class="label label-warning">Belum ada penilai</span>
                    </div>
                    <div id="body">--</div>
                    <div id="bottom">
                        <span class="label label-info">-- Konsumen</span>
                    </div>
                </div>
                @endif    
            <div class="user-data pull-left">
                <div class="title">
                    <h4>{{ $userDetail->nama_user }} <span>{{ $userDetail->alamat }}</span></h4> 
                    <p id="email">{{ $userDetail->email }}</p>
                    <p id="phone">{{ $userDetail->no_telp }}</p>
                </div>
            </div>
            @elseif($mode == "myProfile")
            <div class="user-data pull-left">
                <ul class="">
                    <li>
                        Nama Pengguna <br>
                        <div class="title">
                            {{ $userDetail->nama_user }}
                        </div>
                    </li>
                    <li>
                        Alamat <br>
                        <b>{{ $userDetail->alamat }}</b>
                    </li>
                    <li>
                        Email <br>
                        <b>{{ $userDetail->email }}</b>
                    </li>
                    <li>
                        Nomor Telepon <br>
                        <b>{{ $userDetail->no_telp }}</b>
                    </li>
                </ul>
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target=".uploadModal1"
                    class="btn btn-default btn-block">Edit Profile</a>
                <a href="#" data-toggle="modal" data-target=".uploadModal5"
                    class="btn btn-info btn-block">Tambah Portofolio</a>
            </div>
            <div class="pull-right">
            </div>
            @endif
        </div>
        
        <div class="modal fade uploadModal1" tabindex="-1" 
            role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/WEB/editProfile/{{$user}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_user" value="{{ $userDetail->id_user }}">
                            <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ $userDetail->nama_user }}">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control"
                                    value="{{ $userDetail->alamat }}"> 
                            </div>  
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control"
                                    value="{{ $userDetail->email }}"> 
                            </div>  
                            <div class="form-group">
                                <label>No. Telp</label>
                                <input type="text" name="no_telp" class="form-control"
                                    value="{{ $userDetail->no_telp }}"> 
                            </div>  
                            <br>
                            <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade uploadModal2" tabindex="-1" 
            role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Ganti Foto</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/WEB/changeImageProfile/{{$user}}" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="file" name="img" class="form-control">
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade uploadModal3" tabindex="-1" 
            role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Ubah Password</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/WEB/changePassword/{{$user}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="newpass" class="form-control"
                                    value=""> 
                            </div>  
                            <div class="form-group">
                                <label>Ulangi Password Baru</label>
                                <input type="password" name="repass" class="form-control"
                                    value=""> 
                            </div>  
                            <br>
                            <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade uploadModal4" tabindex="-1" 
            role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Laporkan Penjahit</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/WEB/report-tailor" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_penjahit" value="{{ $tailor_id }}">
                            <div class="form-group">
                                <label>Apa yang ingin anda laporkan?</label>
                                <textarea name="konten" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-warning btn-block" value="Laporkan">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade uploadModal5" tabindex="-1" 
            role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tambah Portofolio</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/WEB/portofolio/add" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>Foto Pakaian</label>
                                <input type="file" name="img" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="desc" maxlength="300" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary btn-block" value="Tambahkan">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <a data-toggle="modal" data-target=".uploadModal4" href="#">Laporkan Penjahit</a>
        </div><br><br>

        <div class="bottom">
            <!-- Nav tabs -->
            @if($mode == "tailorProfile")
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#testimonials" aria-controls="testimonials" 
                        role="tab" data-toggle="tab">Testimonial
                    </a>
                </li>

                <li role="presentation">
                    <a href="#portofolio" aria-controls="portofolio" 
                        role="tab" data-toggle="tab">Portofolio
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tentang" aria-controls="tentang" 
                        role="tab" data-toggle="tab">Tentang
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="testimonials">
                    <br>
                    @if($jlhPenilai > 0)
                        @foreach($testimoni as $komen)
                        <div class="col-md-12 cover">
                            <div class="pull-left">
                                <img src="{{ asset('/images/img1.png') }}">
                            </div>
                            <div class="attr">
                                <div class="col-md-10">
                                    <p><b>{{ $komen->users->nama_user }}</b></p>
                                    <small><i>{{ str_limit($komen->komentar, 300) }}...</i></small>
                                </div>
                                <p id="rate" class="pull-right">
                                </p>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="col-md-12 cover">
                        <p><center><b>Belum ada testimonial</b></center></p>
                    </div>
                    @endif
                </div>

                <div role="tabpanel" class="tab-pane" id="portofolio">
                    <br>
                    <div class="row">
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tentang">
                    <br>
                    <div class="row">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@stop