@section('subtitle') Tambah Portofolio @stop
<div class="row">
    <div class="col-md-8">
        <h1>Tambahkan Porotofolio Anda </h1>
    </div>
</div>
<br>
<div class="content-wrapper">
    <form action="" class="col-md-8">
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="form-group">
            <label>Kategori Pakaian</label>
            <select name="kategori" class="form-control" id="kategori">
                <option value="">-- Pilih Kategori --</option>
                <option value="jas">Jas</option>
                <option value="blazer">Blazzer</option>
                <option value="safari">Safari</option>
                <option value="kemeja kantor">Kemeja Kantor</option>
                <option value="kemeja Batik">Kemeja Batik</option>
                <option value="kemeja Partai">Kemeja Partai</option>
                <option value="kemeja Komunitas">Kemeja Komunitas</option>
                <option value="celana keeper">Celana Keeper</option>
                <option value="celana jeans">Celana Jeans</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Estimasi Harga</label>
            <input type="text" name="price" class="form-control">
        </div>
    </form>
</div>