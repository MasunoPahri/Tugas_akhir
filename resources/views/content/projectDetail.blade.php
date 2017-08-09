@extends('base')

@section('subtitle') Detail Proyek @stop

@section('content')
<div class="row detailProject">
    <div class="col-md-8">
        <h1 id="title">{{ $proyek[0]->nama_proyek }}</h1>
    </div>
    
    @if($sess == "konsumen")
    <div class="col-md-4">
        @if($proyek[0]->status == "draf")
        <div class="col-md-5 pull-right">
            <a href="/WEB/project/publish/{{ $proyek[0]->id_proyek }}" class="btn btn-block btn-primary">Publish</a>
        </div>
        <div class="col-md-5 pull-right">
            <a href="#" data-toggle="modal" data-target=".uploadModal"
                class="btn btn-block btn-default">Upload Desain</a>
        </div>
        @elseif($proyek[0]->status == "pending")
        <div class="col-md-5 pull-right">
            <a href="#" data-toggle="modal" data-target=".uploadModal"
                class="btn btn-block btn-default">Upload Desain</a>
        </div>
        @elseif($proyek[0]->status == "finished")
        <div class="col-md-5 pull-right">
            <a href="#" class="btn btn-block btn-warning" data-toggle="modal" 
                data-target=".testiModal">Buat Testimoni</a>
        </div>
        <div class="col-md-5 pull-right">
            <a href="#" 
                class="btn btn-block btn-info" data-toggle="modal" 
                data-target=".repairModal">Perbaikan</a>
        </div>
        @endif
    </div>
    @elseif($sess == "penjahit")
        @if($hasProject != 1)
            @if(count($proyek[0]->penawar) == 0 || $proyek[0]->penawar[0]->dipilih == 0)
            <div class="col-md-4">
                <div class="col-md-5 pull-right">
                    <a href="/WEB/makebid/{{ $proyek[0]->id_proyek }}" 
                    class="btn btn-block btn-primary">Tawar Proyek</a>
                </div>
            </div>
            @endif
        @endif
        @if($proyek[0]->status == "ongoing")
        <div class="col-md-4">
            <div class="col-md-5 pull-right">
                <a href="/WEB/project/finished/{{ $proyek[0]->id_proyek }}" 
                    class="btn btn-block btn-success">Proyek Selesai</a>
            </div>
        </div>
        @endif
        <!--<div class="col-md-4">
            <div class="col-md-5 pull-right">
                <a href="/WEB/project/finished/{{ $proyek[0]->id_proyek }}" 
                    class="btn btn-block btn-default">Cetak Desain </a>
            </div>
        </div>-->
    @endif
</div>

<div class="modal fade uploadModal" tabindex="-1" 
    role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Desain Contoh Pakaian</h4>
			</div>
			<div class="modal-body">
                <form action="/WEB/uploadDesign/{{$proyek[0]->mode_pengukuran}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <select name="itemPakaian" class="form-control">
                            <option value="">--Pilih Item Pakaian--</option>
                            @foreach($projectAttr as $attr)
                            <option value="{{ $attr->id_item }}">
                                #{{ $iterate += 1 }} {{ $attr->kategori }}
                                @if(count($attr->ukuran) > 0)
                                - Ukuran {{ $attr->ukuran }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" name="foto[]" multiple  class="form-control">
                    </div>  
                    <br>
                    <input type="submit" class="btn btn-primary btn-block" value="Tambahkan">
                </form>
			</div>
		</div>
	</div>
</div>

@if($proyek[0]->status == "finished")
<div class="modal fade testiModal" tabindex="-1" 
    role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content col-md-12">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Isi Testimonial</h4>
			</div>
			<div class="modal-body">
                <div class="stars col-md-12">
                    <form action="/WEB/testimonials/add" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @foreach($proyek as $attr)
                            @foreach($attr->penawar as $attr2)
                                @if($attr2->dipilih == 1)
                                    <input type="hidden" name="id_penjahit" value="{{$attr2->id_penjahit}}">
                                @endif
                            @endforeach
                        @endforeach
                        <label for="rate">Nilai</label>
                        <div class="col-md-12" id="rate">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input id="rate1" type="radio" name="star" value="5">
                                    <label for="rate1" class="label label-success">Sangat Puas</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="rate2" type="radio" name="star" value="4">
                                    <label for="rate2" class="label label-primary">Puas</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="rate3" type="radio" name="star" value="3">
                                    <label for="rate3" class="label label-default">Biasa Saja</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="rate4" type="radio" name="star" value="2">
                                    <label for="rate4" class="label label-warning">Buruk</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="rate5" type="radio" name="star" value="1">
                                    <label for="rate5" class="label label-danger">Sangat Buruk</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="komentar">Komentar</label>
                            <textarea name="komentar" class="form-control" id="komentar"
                                cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-success" value="Kirimkan">
                            <br>
                        </div>
                        <br>
                    </form>
                </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade repairModal" tabindex="-1" 
    role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Minta Perbaikan</h4>
			</div>
			<div class="modal-body">
                <form action="/WEB/reture/{{$proyek[0]->id_proyek}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id_penjahit" value="{{$proyek[0]->penawar[0]->id_penjahit}}">
                    <div class="form-group">
                        <label>Keluhan</label>
                        <textarea name="komentar" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary btn-block" value="Kirimkan">
                </form>
			</div>
		</div>
	</div>
</div>
@endif

<div class="view-detail">
    @if( $sess == "konsumen" )
        @if($proyek[0]->status == "draf")
        <div class="alert alert-danger">
            Proyek masih dalam status draf! Klik tombol <b>Publish</b> untuk mendapatkan tawaran!
        </div>
        @elseif($hasBill == 1)
        <div class="alert alert-danger">
            Anda belum melakukan konfirmasi pembayaran atau konfirmasi sedang diproses!
            <a href="#"><b>Konfirmasi</b></a> sekarang!
        </div>
        @endif
    @endif
    <div class="itemList">
        <div style="display:none;">{{ $iterate = 0 }}</div>
        {{dd($projectAttr)}}
        @foreach($projectAttr as $attr)
        <div class="col-md-6 items">
            <div class="itemHead">
                <p id="title">#{{ $iterate += 1 }} - {{ $attr->kategori }}</p>
                <p id="subItem">
                    <span> <b>Ukuran</b> {{ $attr->ukuran }} - </span>
                    <span> <b>Jumlah Pakaian</b> {{ $attr->jlhPakaian }} </span>
                </p>
            </div>
            <div class="itemBody col-md-12">
                <p> {{ $attr->deskripsi }} </p>
                <div class="img">
                    @if(count($attr->design) > 0)
                        @foreach($attr->design as $image)
                        <div class="col-md-4">
                            <img src="{{ asset('/images') }}/{{ $image->images }}" alt="">
                        </div>
                        @endforeach
                    @else
                        <p><center>Tidak ada contoh desain</center></p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @if( ($viewMode == "pendingView" && $sess == "konsumen") || ($hasProject == 0 && $sess == "penjahit"))
    <div class="bidList col-md-12">
        <h3>Daftar Penawar</h3>
        @if(count($bidList) > 0)
        <table class="bidlist">
            <thead>
                <tr>
                    <th style="width: 40%">Nama Penjahit</th>
                    <th style="width: 10%">Ratting</th>
                    <th style="width: 20%">Lama Pengerjaan</th>
                    <th style="width: 20%">Tawaran Harga</th>
                    <th style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($bidList as $list)
                <div class="modal fade profile_{{ $list->penjahit->nama_user }}" tabindex="-1" 
                    role="dialog" aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content col-md-12">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Detail Profil {{ $list->penjahit->nama_user }}</h4>
                            </div>
                            <div class="modal-body col-md-12">
                                <div class="col-md-4">
                                    <img style="width: 165px" src="{{ asset('/images') }}/{{ $list->penjahit->foto }}" alt="">
                                </div>
                                <div class="col-md-8">
                                    <ul>
                                        <li><b>Nama Penjahit</b>: {{ $list->penjahit->nama_user }}</li>
                                        <li><b>Email</b>: {{ $list->penjahit->email }}</li>
                                        <li><b>Alamat</b>: {{ $list->penjahit->alamat }}</li>
                                        <li><b>No. Telpon</b>: {{ $list->penjahit->no_telp }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <tr>
                    <td>
                        <span class="imgmini pull-left">
                            <img src="{{ asset('/images') }}/{{ $list->penjahit->foto }}" alt="">
                        </span>
                        <span class="userdt pull-left">
                            <b>
                                <a href="#" data-toggle="modal" data-target=".profile_{{ $list->penjahit->nama_user }}">
                                {{ $list->penjahit->nama_user }}
                                </a>
                            </b><br>
                            {{ $list->penjahit->alamat }}
                        </span>
                    </td>
                    <td>
                        --
                    </td>
                    <td>
                        {{ $list->lama_pengerjaan }}
                    </td>

                    <td>
                        Rp. {{ number_format($list->harga, 2, ',', '.') }}
                    </td>
                    @if($sess == "konsumen")
                    <td>
                        @if($list->dipilih == 0)
                        <form action="/WEB/choose/start" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idproyek" value="{{ $list->id_proyek }}">
                            <input type="hidden" name="iduser" value="{{ $list->penjahit->id_user }}">
                            <input type="hidden" name="tipe_bayar" value="{{ $tipe_bayar }}">
                            <input type="submit" class="btn btn-info btn-block" value="Pilih Penjahit">
                        </form>
                        @else
                        <a href="#" disabled class="btn btn-info btn-block">Penjahit Terpilih</a>
                        @endif
                    </td>
                    @else
                    <td style="width: 0%"> --</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <h4><center>Belum Ada Penawar!!</center></h4>
        @endif
    </div>
    @endif
</div>
@stop
