@extends('base')

@section('subtitle') Dasbor {{ $user }} @stop

@section('content')
    @if($viewMode == "konsumen")
        @include('content.partials.dsb_konsumen')
    @elseif($viewMode == "penjahit")
        @include('content.partials.dsb_penjahit')
    @endif
@stop