<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menjarum | Informasi Pribadi</title>
	<link rel="stylesheet" href="{{ asset('/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/main-style.css') }}">
	<link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>

    <div class="container">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="coverData">
                @if (Session::has('message'))
                    <div class="alert alert-danger">{{ Session::get('message') }}</div>
                @endif
                <div class="alert alert-danger">
                    Anda harus melengkapi informasi pribadi terlebih dahulu!!
                </div>
                <form action="/block/completed-data/{{$user}}" method="post" enctype="multipart/form-data" class="col-md-12">
    				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h4>Silahkan lengkapi informasi pribadi anda...</h4>
                    <div class="form-group">
                        @if($role == "penjahit")
                            <p><b>Kemampuan</b></p>
                            @foreach($skills as $skill)
                                <input type="checkbox" id="ch{{$skill->id_skill}}" 
                                    name="skills" value="{{$skill->nama_skill}}">
                                <label for="ch{{$skill->id_skill}}">{{$skill->nama_skill}}</label>
                            @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon / HP</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="img" class="form-control">
                    </div>
                    <div class="pull-left back">
                        <a href="/">Kembali ke halman depan</a>
                    </div>
                    <div class="pull-right">
                        <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                    </div>
                    <br>
                </form>
                <br>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="spaceBlock"></div>
    </div>

    <script src=" {{ URL::to('bootstrap/js/jquery-2.0.2.min.js') }} "></script>
    <script src=" {{ URL::to('bootstrap/js/bootstrap.min.js') }} "></script>
    <script src=" {{ URL::to('js/main.js') }} "></script>
</body>
</html>