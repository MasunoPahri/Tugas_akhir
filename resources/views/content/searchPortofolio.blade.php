@extends('base')

@section('subtitle') Cari Portofolio @stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <h3>Portofolio </h3>
    </div>
    <div class="col-md-4">
        <br>
        <form action="/WEB/portofolio-search" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="cari" placeholder="masukkan kata kunci"
                class="form-control">
        </form>
    </div>
</div>
<br>
<div class="content">
    <br>
    <div class="row">
        @foreach($portofolios as $portofolio)
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="{{ asset('/images/') }}/{{ $portofolio->foto }}" alt="...">
                <div class="caption">
                    <p>{{ $portofolio->deskripsi }}</p>
                    <br>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop
