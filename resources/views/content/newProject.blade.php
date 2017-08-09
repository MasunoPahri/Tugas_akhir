@extends('base')

@section('subtitle') Proyek Baru @stop

@section('content')
    @if($viewMode == "new")
        @include('content.partials.np_basicData')
    @elseif($viewMode == "customize")
        {{ $title }} 
        @include('content.partials.np_sizingCustomize')
    @elseif($viewMode == "standart")
        {{ $title }} 
        @include('content.partials.np_sizingStandart')
    @elseif($viewMode == "deliverData")
        @include('content.partials.np_deliverData')
    @elseif($viewMode == "confirm")
        @include('content.partials.np_confirm')
    @endif
@stop