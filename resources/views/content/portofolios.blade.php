@extends('base')

@section('content')
    @if($viewMode == "list")
        @include('content.partials.listPorto')
    @elseif($viewMode == "add")
        @include('content.partials.addPorto')
    @endif
@stop