@extends('base')

@section('subtitle')Daftar Semua Penawar @stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Daftar Penawar </h1>
    </div>
</div>
<br>
<div class="container">
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
            <tr>
                <td>
                    <span class="imgmini pull-left">
                        <img src="{{ asset('/images/img1.png') }}" alt="">
                    </span>
                    <span class="userdt pull-left">
                        <b>{{ $list->penjahit->nama_user }}</b><br>
                        {{ $list->penjahit->alamat }}
                    </span>
                </td>
                <td>
                    8.5
                </td>
                <td>
                    {{ $list->lama_pengerjaan }}
                </td>

                <td>
                    Rp. {{ number_format($list->harga, 2, ',', '.') }}
                </td>
                <td>
                    <form action="/WEB/choose/start" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="idproyek" value="{{ $list->id_proyek }}">
                        <input type="hidden" name="iduser" value="{{ $list->penjahit->id_user }}">
                        <input type="submit" class="btn btn-info btn-block" value="Pilih Penjahit">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <h4><center>Belum Ada Penawar!!</center></h4>
    @endif
</div>
@stop
