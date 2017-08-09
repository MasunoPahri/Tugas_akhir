@extends('base')

@section('subtitle') Tawar Proyek @stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Buat Tawaran Proyek </h1>
    </div>
</div>
<br>
<form action="/WEB/bid/{{ $pid }}" method="post" class=form-horizontal"">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idp" value="{{ $pid }}">
    <div class="form-group row">
        <label class="col-md-2 ">Lama Pengerjaan</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="timerange"
                placeholder="masukkan estimasi waktu pengerjaan" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 ">Harga Tawaran</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="bidprice"
                placeholder="masukkan harga tawaran">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 "></label>
        <div class="col-md-6">
            <button type="submit" class="btn btn-info">Selanjutnya</button>
        </div>
    </div>
</form>
@stop
