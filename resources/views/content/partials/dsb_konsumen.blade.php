<div class="row">
    <div class="col-md-8">
        <h1>Dasbor {{ $sess }} </h1>
    </div>
</div>
<br>
        <a href="/WEB/projects/all/all" class="btn btn-info btn-sm">Semua Proyek</a>
        <a href="/WEB/projects/pending/1" class="btn btn-default btn-sm">Pending</a>
        <a href="/WEB/projects/ongoing/1" class="btn btn-default btn-sm">Proses</a>
        <a href="/WEB/projects/finished/1" class="btn btn-default btn-sm">Selesai</a>
<div class="content">
    <br>
    <div class="row">
        @foreach($projects as $project)
            <div class="itemProject col-sm-6 col-md-4">
                <div class="content bordered col-md-12">
                    @if($status == "pending" || $status == "all")
                    <span class="label label-info">
                        {{ $project->status }}
                    </span>
                    @elseif($status == "ongoing")
                    <span class="label label-warning">
                        {{ $project->status }}
                    </span>
                    @elseif($status == "finished")
                    <span class="label label-success">
                        {{ $project->status }}
                    </span>
                    @endif
                    <h4>
                        <a href="/WEB/view-detail/{{ $project->status }}/{{ $project->id_proyek }}">
                            {{ $project->nama_proyek }}
                        </a>
                    </h4>
                    @if($project->status == "pending" || $project->status == "draf")
                    {{ count($project->penawar) }} Penawaran
                    @else
                    <i>Dijahit oleh </i>{{ $project->users->nama_user }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>