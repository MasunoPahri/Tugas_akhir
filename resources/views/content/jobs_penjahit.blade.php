@extends('base')

@section('subtitle') Semua poryek @stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Daftar Proyek </h1>
    </div>
</div>
<br>
<div class="content">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#bidded" aria-controls="bidded" 
                role="tab" data-toggle="tab">Proyek Ditawar
            </a>
        </li>
        <li role="presentation">
            <a href="#finish" aria-controls="finish" 
                role="tab" data-toggle="tab">Proyek Selesai
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="bidded">
            <br>
            <div class="row">  
                @foreach($biddedProject as $project)
                    @foreach($project->tailorsBid as $myBids)
                        @if($myBids->status == "ongoing" || $myBids->status == "pending")
                        <div class="itemProject col-sm-6 col-md-4">
                            <div class="content bordered col-md-12">
                                <span class="label label-info">
                                    {{ $myBids->status }}
                                </span>
                                <h4>
                                    <a href="/WEB/view-detail/{{ $myBids->status }}/{{ $myBids->id_proyek }}">
                                        {{ $myBids->nama_proyek }}
                                    </a>
                                </h4>
                                {{ count($myBids->penawar) }} Penawaran
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="finish">
            <br>
            <div class="row"> 
                @foreach($biddedProject as $project)
                    @foreach($project->tailorsBid as $myBids)
                        @if($myBids->status == "finished")
                        <div class="itemProject col-sm-6 col-md-4">
                            <div class="content bordered col-md-12">
                                <span class="label label-info">
                                    {{ $myBids->status }}
                                </span>
                                <h4>
                                    <a href="/WEB/view-detail/{{ $myBids->status }}/{{ $myBids->id_proyek }}">
                                        {{ $myBids->nama_proyek }}
                                    </a>
                                </h4>
                                {{ count($myBids->penawar) }} Penawaran
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop
