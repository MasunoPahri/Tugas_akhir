@section('subtitle') Daftar Portofolio @stop
<div class="row">
    <div class="col-md-12">
        <h1 class="pull-left">Portofolio Anda </h1>
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
                    <p>
                        <form action="/WEB/portofolio/dltPorto" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_porto" value="{{ $portofolio->id }}">
                            <input type="submit" class="btn btn-danger btn-block" value="Hapus">
                        </form>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!--
<div class="modal fade uploadModal" tabindex="-1" 
    role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Portofolio</h4>
            </div>
            <div class="modal-body">
                <form action="/WEB/portofolio/add" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Foto Pakaian</label>
                        <input type="file" name="img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="desc" maxlength="300" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary btn-block" value="Tambahkan">
                </form>
            </div>
        </div>
    </div>
</div>-->