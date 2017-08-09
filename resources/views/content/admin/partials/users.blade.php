@extends('content.admin.admin_base')

@section('subtitle') Pengguna @stop
@section('pageTitle') Pengguna @stop
@section('username'){{ $sess }}@stop

@section('content')
<div class="bidList">
    <div class="hd">
        <div class="col-md-8">
            <h3>Daftar Pengguna</h3>
        </div>
        <div class="col-md-4">
            <div class="scInput">
                <form action="/adminpanel/sendString" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" class="form-control" name="string"
                        placeholder="Cari pengguna..">
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12"><br>
        <table class="bidlist">
            <thead>
                <tr>
                    <th style="width: 40%">Pengguna</th>
                    <th style="width: 20%">Alamat</th>
                    <th style="width: 20%">Telepon</th>
                    <th style="width: 20%">Peran</th>
                    <th style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <b>{{ $user->nama_user }}</b><br>
                        {{ $user->email }}
                    </td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->no_telp }}</td>
                    <td>{{ $user->peran }}</td>
                    <td>
                        <a href="/adminpanel/dltuser/{{ $user->id_user }}" class="btn btn-danger btn-block">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop