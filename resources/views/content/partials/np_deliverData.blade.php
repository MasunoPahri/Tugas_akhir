<div class="row hd">
    <div class="col-md-8">
        <h2>Buat Proyek Baru</h2>
        <p>Data Pengiriman</p>
    </div>
</div>
<br>
<form action="/WEB/project/confirm" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                <span><label><input type="radio" name="priceType" required value="cicilan">Cicilan</label></span>
                <span><label><input type="radio" name="priceType" required value="lunas">Bayar Lunas</label></span>
            </div>
        </div>
    </div>
    
    <div class="prevData">
        @foreach($dataSec as $item => $v)
            @if($item != 'title' && $item != '_token' && $item != 'sizingMode')
                @foreach($v as $sizing )
                    <input type="hidden" name="{{ $item }}[]" value="{{ $sizing }}">
                @endforeach
            @else
               <input type="hidden" name="{{ $item }}" value="{{ $v }}">
            @endif
        @endforeach
    </div>
    
    <div class="col-md-offset-6">
        <div class="col-md-4">
            <button type="submit" class="btn btn-info btn-block">Selanjutnya</button>
        </div>
    </div>
</form>