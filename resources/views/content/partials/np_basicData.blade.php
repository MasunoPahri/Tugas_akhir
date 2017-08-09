<div class="row hd">
    <div class="col-md-8">
        <h2>Buat Proyek Baru</h2>
        <p>Info Dasar</p>
    </div>
</div>
<br>
<div class="form">
    <form action="/WEB/project/sizing" method="post" class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-2 ">Judul Proyek</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="title" required
                    placeholder="contoh: Kemeja Batik Perusahaan PT. XYZ">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 ">Alamat Pengiriman</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="address" required
                    placeholder="contoh: Kemeja Batik Perusahaan PT. XYZ"
                    value="{{ $alamat }}">
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-md-2 ">Pilih Metode Pembayaran</label>
            <div class="col-md-6">
                <div class="radio">
                    <label><input type="radio" name="priceType" required value="cicilan">
                        <span class="label label-warning">Cicilan</span>
                    </label>
                    <label><input type="radio" name="priceType" required value="penuh">
                        <span class="label label-success">Bayar Penuh</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 ">Pilih Metode Pengukuran</label>
            <div class="col-md-6">
                <div class="radio">
                    <label><input type="radio" name="sizingType" required value="customize">
                        <span class="label label-primary">Ukuran Sendiri</span>
                    </label>
                    <label><input type="radio" name="sizingType" required value="standart">
                        <span class="label label-info">Ukuran Standart</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="col-md-offset-6">
            <div class="col-md-4">
                <button class="btn btn-info btn-block">Selanjutnya</button>
            </div>
        </div>
    </form>
</div>