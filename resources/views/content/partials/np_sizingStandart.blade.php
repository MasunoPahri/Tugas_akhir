<div class="row hd">
    <div class="col-md-8">
        <h2>Buat Proyek Baru</h2>
        <p>Pengukuran - Ukuran sendiri</p>
    </div>
</div>
<br>
<div class="content-wrapper">
    <form class="form-horizontal" id="inItemPakaian">
        <div class="col-md-8">
            <div class="form">
                <div class="form-group">
                    <label class="col-md-3 ">Kategori Pakaian</label>
                    <div class="col-md-8">
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
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 ">Ukuran Pakaian</label>
                    <div class="col-md-8">
                        <select name="size" class="form-control" id="size">
                            <option value="">-- Pilih Ukuran --</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label class="col-md-3 ">Jumlah Pakaian</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="pcs"
                            placeholder="contoh: 30" id="pcs">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 ">Deksripsi/Keterangan</label>
                    <div class="col-md-8">
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="10"></textarea>
                    </div>
                </div>
                
                <div class="col-md-offset-9">
                    <div class="col-md-9">
                        <a href="#covItem" sizeMode="standart"
                            class="btn btn-default btn-block" id="addItem">Tambahkan</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading" id="covItem">
                <h3 class="panel-title">Panel title</h3>
            </div>
            <div class="panel-body">
                <form action="/WEB/storeProject" method="post" class="formPakaian">
                    <div class="panel-group itemList" id="accordion" role="tablist" aria-multiselectable="true">
                        
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="title" value="{{ $title }}">
                    <input type="hidden" name="address" value="{{ $address }}">
                    <input type="hidden" name="priceType" value="{{ $price_type }}">
                    <input type="hidden" name="sizingMode" value="standart">

                    <div class="itemPakaian">
                    </div>
                    
                    <p class="pull-right">
                        <button type="submit" class="btn btn-info">Selanjutnya</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<br>