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
    <br>
    <div class="row">
        @if($hasProject >= 1)
        <div class="alert alert-danger">
            Anda tidak dapat melakukan penawaran selama masih dalam proyek berjalan!!
        </div>
        @endif
        @foreach($projects as $project)
            <div class="itemProject col-sm-6 col-md-4">
                <div class="content col-md-12">
                    <span class="label label-info">
                        {{ $project->status }}
                    </span>
                    <h4>
                        <a href="/WEB/view-detail/pending/{{ $project->id_proyek }}">
                            {{ $project->nama_proyek }}
                        </a>
                    </h4>
                    {{ count($project->penawar) }} Penawaran
                </div>
                @if($hasProject == 0)
                    @if(count($project->penawar) == 0 || $project->penawar[0]->dipilih == 0)
                    <div class="btn-cta col-md-12">
                        <a href="/WEB/makebid/{{ $project->id_proyek }}" class="btn btn-block">Tawar Proyek</a>
                    </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
@stop
