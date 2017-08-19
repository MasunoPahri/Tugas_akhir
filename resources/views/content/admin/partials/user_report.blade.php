@extends('content.admin.admin_base')

@section('subtitle') Laporan @stop
@section('pageTitle') Laporan Konsumen @stop

@section('content')

<div class="row">
    <div class="col-md-8">
        <h3>Daftar Laporan</h3>
    </div>
</div>
<br>
<div class="content">
    <br>
    <div class="reports col-md-12">
        @foreach($reports as $report)
        <div class="itemReport col-md-4">
            <p id="name"><a href="#">{{ $report->tailors->nama_user }}</a></p>
            <small>{{ $report->tailors->no_telp }}</small>
            <div class="ctn">
                <p>{{ $report->konten }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop