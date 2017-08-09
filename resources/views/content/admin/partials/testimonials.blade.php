@extends('content.admin.admin_base')

@section('subtitle') Testimonial @stop
@section('pageTitle') Testimonial @stop

@section('content')

<div class="row">
    <div class="col-md-8">
        <h1>Moderasi Testimonial </h1>
    </div>
</div>
<br>
<div class="content">
    <br>
    <div class="row">
        @foreach($testimonial as $testimoni)
            <div class="itemProject col-sm-6 col-md-4">
                <div class="content col-md-12">
                    @if($testimoni->status_terbit == 0)
                    <span class="label label-danger">
                        Belum Terbit
                    </span>
                    @else
                    <span class="label label-success">
                        Diterbitkan
                    </span>
                    @endif
                    <h4>
                        <a href="#">
                            Rattings {{ $testimoni->ratting }}
                        </a>
                    </h4>
                    {{ $testimoni->komentar }}
                </div>
                <div class="col-md-12 ctaCover">
                    <div class="btn-cta grant col-md-6">
                        <a href="/adminpanel/up_testimoni/{{ $testimoni->id_testimoni }}" class="btn btn-block">Terbitkan</a>
                    </div>
                    <div class="btn-cta dlt col-md-6">
                        <a href="/adminpanel/dlt_testimoni/{{ $testimoni->id_testimoni }}" class="btn btn-block">Hapus</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop