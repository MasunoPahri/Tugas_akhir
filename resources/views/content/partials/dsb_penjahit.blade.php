<div class="row">
    <div class="col-md-8">
        <h1>Dasbor {{ $sess }} </h1>
    </div>
</div>
<br>
<div class="Tmain-wrapper">
    <div class="container">
        <div class="col-md-4 user-panel">
            <div class="row">
                <div class="pull-left imgUser">
                    <img src="" alt="">
                </div>
                <div class="user-data pull-left">
                    <p id="username">{{ $user }}</p>
                    <p id="rattings">Ratting Anda</p>
                    <a href="/WEB/portofolio/add" class="btn btn-info btn-block">Tambah Portofilio</a>
                </div>
            </div>
        </div>
        <div class="col-md-7 allnews pull-right">
            <div class="row hdTitle">
                <h4>Kabar Berita</h4>
            </div>
            <div class="news-wrapper">
                <div class="item-news row">
                    <div class="pull-left imgItem">
                        <img src="" alt="">
                    </div>
                    <div class="pull-left ctnItem">
                        <p id="username">isi pesan deskripsi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>