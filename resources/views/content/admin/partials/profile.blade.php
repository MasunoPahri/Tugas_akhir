@extends('content.admin.admin_base')

@section('subtitle') Profile @stop
@section('pageTitle') Profile @stop

@section('content')
<div class="col-md-12 profile-wrapper">
    <div class="col-md-3 leftside">
        <div class="upper">
            <div class="img-profile">
                <img src="{{ asset('/images') }}/{{ $userDetail->foto }}" alt="">
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
            <div class="score pull-left">
                <div id="title">Ratting</div>
                <div id="body">8.5</div>
                <div id="bottom">100 proyek</div>
            </div>
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
                    class="btn btn-info btn-block">Edit Profile</a>
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

        <div class="bottom">
            <!-- Nav tabs -->
            @if($mode == "tailorProfile")
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#testimonials" aria-controls="testimonials" 
                        role="tab" data-toggle="tab">testimonials
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
                    <div class="col-md-12 cover">
                        <div class="pull-left">
                            <img src="{{ asset('/images/img1.png') }}">
                        </div>
                        <div class="attr">
                            <div class="pull-left">
                                <p><b>Rian Dirgantara</b></p>
                                <small><i>Pelayanan dan hasil jahitnya sangat memuaskan!</i></small>
                            </div>
                            <p id="rate" class="pull-right">
                                <input class="star star-5" id="star-5-2" type="radio" 
                                    disabled value="5" checked />
                                <label class="star star-5" for="star-5-2"></label>
                                <input class="star star-4" id="star-4-2" type="radio" 
                                    disabled value="4" />
                                <label class="star star-4" for="star-4-2"></label>
                                <input class="star star-3" id="star-3-2" type="radio" 
                                    disabled value="3" />
                                <label class="star star-3" for="star-3-2"></label>
                                <input class="star star-2" id="star-2-2" type="radio" 
                                    disabled value="2" />
                                <label class="star star-2" for="star-2-2"></label>
                                <input class="star star-1" id="star-1-2" type="radio" 
                                    disabled value="1" />
                                <label class="star star-1" for="star-1-2"></label>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 cover">
                        <div class="pull-left">
                            <img src="{{ asset('/images/img1.png') }}">
                        </div>
                        <div class="attr">
                            <div class="pull-left">
                                <p><b>Budi Adriawan</b></p>
                                <small><i>Hasil jahitan cukup rapih!</i></small>
                            </div>
                            <p id="rate" class="pull-right">
                                <input class="star star-5" id="star-5-2" type="radio" 
                                    disabled value="5" />
                                <label class="star star-5" for="star-5-2"></label>
                                <input class="star star-4" id="star-4-2" type="radio" 
                                    disabled value="4" checked />
                                <label class="star star-4" for="star-4-2"></label>
                                <input class="star star-3" id="star-3-2" type="radio" 
                                    disabled value="3" />
                                <label class="star star-3" for="star-3-2"></label>
                                <input class="star star-2" id="star-2-2" type="radio" 
                                    disabled value="2" />
                                <label class="star star-2" for="star-2-2"></label>
                                <input class="star star-1" id="star-1-2" type="radio" 
                                    disabled value="1" />
                                <label class="star star-1" for="star-1-2"></label>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 cover">
                        <div class="pull-left">
                            <img src="{{ asset('/images/img1.png') }}">
                        </div>
                        <div class="attr">
                            <div class="pull-left">
                                <p><b>Adul Sukardi</b></p>
                                <small><i>Jahitan robek saat dites kebadan/ukuran salah!</i></small>
                            </div>
                            <p id="rate" class="pull-right">
                                <input class="star star-5" id="star-5-2" type="radio" 
                                    disabled value="5" />
                                <label class="star star-5" for="star-5-2"></label>
                                <input class="star star-4" id="star-4-2" type="radio" 
                                    disabled value="4" />
                                <label class="star star-4" for="star-4-2"></label>
                                <input class="star star-3" id="star-3-2" type="radio" 
                                    disabled value="3" />
                                <label class="star star-3" for="star-3-2"></label>
                                <input class="star star-2" id="star-2-2" type="radio" 
                                    disabled value="2" />
                                <label class="star star-2" for="star-2-2"></label>
                                <input class="star star-1" id="star-1-2" type="radio" 
                                    disabled value="1" checked/>
                                <label class="star star-1" for="star-1-2"></label>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 cover">
                        <div class="pull-left">
                            <img src="{{ asset('/images/img1.png') }}">
                        </div>
                        <div class="attr">
                            <div class="pull-left">
                                <p><b>Rio Kurniawan</b></p>
                                <small><i>Cukup memuaskan!</i></small>
                            </div>
                            <p id="rate" class="pull-right">
                                <input class="star star-5" id="star-5-2" type="radio" 
                                    disabled value="5"/>
                                <label class="star star-5" for="star-5-2"></label>
                                <input class="star star-4" id="star-4-2" type="radio" 
                                    disabled value="4" />
                                <label class="star star-4" for="star-4-2"></label>
                                <input class="star star-3" id="star-3-2" type="radio" 
                                    disabled value="3" checked/>
                                <label class="star star-3" for="star-3-2"></label>
                                <input class="star star-2" id="star-2-2" type="radio" 
                                    disabled value="2" />
                                <label class="star star-2" for="star-2-2"></label>
                                <input class="star star-1" id="star-1-2" type="radio" 
                                    disabled value="1" />
                                <label class="star star-1" for="star-1-2"></label>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-12 cover">
                        <div class="pull-left">
                            <img src="{{ asset('/images/img1.png') }}">
                        </div>
                        <div class="attr">
                            <div class="pull-left">
                                <p><b>Surya Oktavia</b></p>
                                <small><i>Recommended nih penjahit! Selalu memuaskan pelanggan dengan hasil jahitannya</i></small>
                            </div>
                            <p id="rate" class="pull-right">
                                <input class="star star-5" id="star-5-2" type="radio" 
                                    disabled value="5" checked />
                                <label class="star star-5" for="star-5-2"></label>
                                <input class="star star-4" id="star-4-2" type="radio" 
                                    disabled value="4" />
                                <label class="star star-4" for="star-4-2"></label>
                                <input class="star star-3" id="star-3-2" type="radio" 
                                    disabled value="3" />
                                <label class="star star-3" for="star-3-2"></label>
                                <input class="star star-2" id="star-2-2" type="radio" 
                                    disabled value="2" />
                                <label class="star star-2" for="star-2-2"></label>
                                <input class="star star-1" id="star-1-2" type="radio" 
                                    disabled value="1" />
                                <label class="star star-1" for="star-1-2"></label>
                            </p>
                        </div>
                    </div>

                    
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