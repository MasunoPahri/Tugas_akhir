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

                <div class="k_special">
                    <div class="form-group">
                        <label class="col-md-3 ">Lingkar Badan</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="l_badan"
                                placeholder="contoh: 30cm" id="l_badan">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Lingkar Pinggang</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="l_pinggang"
                                placeholder="contoh: 30cm" id="l_pinggang">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Lingkar Pinggul</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="l_pinggul"
                                placeholder="contoh: 30cm" id="l_pinggul">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Lingkar Pundak</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="l_pundak"
                                placeholder="contoh: 30cm" id="l_pundak">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Panjang Lengan</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="p_lengan"
                                placeholder="contoh: 30cm" id="p_lengan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 ">Panjang Blazzer</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="p_blazzer"
                                placeholder="contoh: 50cm" id="p_blazzer">
                        </div>
                    </div>
                </div>

                <div class="k_special2">
                    <div class="form-group">
                        <label class="col-md-3 ">Panjang Celana</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="pjgCelana"
                                placeholder="contoh: 30cm" id="pjgCelana">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Keliling Pinggang</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="k_pinggang"
                                placeholder="contoh: 30cm" id="k_pinggang">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Lingkar Pisak</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="l_pisak"
                                placeholder="contoh: 30cm" id="l_pisak">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 ">Keliling Kaki</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="k_kaki"
                                placeholder="contoh: 30cm" id="k_kaki">
                        </div>
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
                        <a href="#covItem" sizeMode="customize"
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
                <div class="panel-group itemList" id="accordion" role="tablist" aria-multiselectable="true">
                    
                </div>
                <form action="/WEB/storeProject" method="post" class="formPakaian">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="title" value="{{ $title }}">
                    <input type="hidden" name="address" value="{{ $address }}">
                    <input type="hidden" name="priceType" value="{{ $price_type }}">
                    <input type="hidden" name="sizingMode" value="customize">

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