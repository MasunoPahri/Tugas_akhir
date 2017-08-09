<div class="row hd">
    <div class="col-md-8">
        <h2>Buat Proyek Baru</h2>
        <p>Konfirmasi Proyek</p>
    </div>
</div>
<br>
<div class="content-wrapper">
    <div class="container">
        <div class="col-md-3"></div>
        <div class="col-md-6 projectDetail">
            <h3 id="title">{{ $finalData['title'] }} </h3>
            <p id="sizingMode">
                <span class="glyphicon glyphicon-tags"> </span>  Pengukuran {{ $finalData['sizingMode'] }}
            </p>
            <p id="address">
                <span class="glyphicon glyphicon-map-marker"></span>  {{ $finalData['address'] }}
            </p>
            <p id="priceType">
                <span class="glyphicon glyphicon-usd"></span>  {{ $finalData['priceType'] }}
            </p>
            <form action="/WEB/storeProject" method="post" class="size col-md-12" enctype="multipart/form-data">
                <div class="">
                    <div class="form-group">
                        <label for="image">Contoh Desain</label>
                        <input type="file" class="form-control" name="image[]" multiple>
                    </div>
                    <br>
                    <p><span class="glyphicon glyphicon-th-list"></span>  <b>Item Pakaian</b></p>
                    @for($i=0; $i < $count; $i++)
                    <div class="col-md-6 itemSize">
                        <div class="itemHead">
                            Pakaian {{ $i+1 }}
                        </div>
                        <div class="itemBody col-md-12"> 
                            @if($finalData['sizingMode'] == "customize")
                            <p><b>{{ $finalData['kategori'][$i] }}</b></p>
                            <p>Lingkar Badan:{{ $finalData['l_badan'][$i] }}</p>
                            <p>Lingkar Pinggang {{ $finalData['l_pinggang'][$i] }}</p>
                            <p>Lingkar Pundak {{ $finalData['l_pundak'][$i] }}</p>
                            <p>Panjang Lengan {{ $finalData['p_lengan'][$i] }}</p>
                            <p>Panjang Blazzer {{ $finalData['p_blazzer'][$i] }}</p>
                            <p>Keterangan {{ $finalData['desc'][$i] }}</p>
                            @elseif($finalData['sizingMode'] == "standart")
                            <p><b>{{ $finalData['kategori'][$i] }}</b></p>
                            <p>Ukuran Pakaian {{ $finalData['letterSize'][$i] }}</p>
                            <p>Jumlah Pakaian {{ $finalData['jlhPakaian'][$i] }}</p>
                            @endif
                        </div> 
                    </div>
                    @endfor
                </div>
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="uID" value="{{ $userID }}">
                <div class="prevData col-md-offset-1">
                    @foreach($finalData as $item => $v)
                        @if($item != 'title' && $item != '_token' && $item != 'sizingMode'
                        && $item != 'address' && $item != 'priceType')
                            @foreach($v as $sizing )
                                <input type="hidden" name="{{ $item }}[]" value="{{ $sizing }}">
                            @endforeach
                        @else
                        <input type="hidden" name="{{ $item }}" value="{{ $v }}">
                        @endif
                    @endforeach
                    <div class="col-md-1"></div>
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <input type="submit" name="state" value="Draf" class="btn btn-info btn-block"> 
                        </div>
                        <div class="col-md-5">
                            <input type="submit" name="state" value="Selesai" class="btn btn-success btn-block">
                        </div>  
                    </div>     
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<br>