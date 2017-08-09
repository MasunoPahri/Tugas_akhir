@extends('content.admin.admin_base')

@section('subtitle') Pembayaran @stop
@section('pageTitle') Pembayaran @stop
@section('username'){{ $sess }}@stop

@section('content')
<div class="bidList col-md-12">
    <h3>Daftar Pembayaran</h3>
    <table class="bidlist">
        <thead>
            <tr>
                <th style="width: 10%">Invoice</th>
                <th style="width: 20%">Tanggal</th>
                <th style="width: 20%">Jumlah Pembayaran</th>
                <th style="width: 10%">Jenis Pembayaran</th>
                <th style="width: 10%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($allBills as $bill)
            <tr>
                <td>
                    <b>#{{ $bill->invoice_num }}</b><br>
                    @if($bill->ket == "lunas")
                        <span class="label label-success">{{ $bill->ket }}</span>
                    @else
                        <span class="label label-warning">{{ $bill->ket }}</span>
                    @endif
                </td>
                <td>{{ $bill->tgl_bayar }}</td>
                <td>
                    Rp. {{ number_format($bill->jlh_bayar, 2, ',', '.') }}
                </td>
                <td>
                    @if( $bill->tipe_bayar == "separate1" )
                        cicilan 1
                    @elseif( $bill->tipe_bayar == "separate2" )
                        cicilan 2
                    @else
                    {{ $bill->tipe_bayar }}
                    @endif
                </td>
                <td>
                    @if($bill->ket != "lunas")
                    <form action="/adminpanel/invoice/confirmed" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="invoice_num" value="{{ $bill->invoice_num }}">
                        <input type="hidden" name="id_proyek" value="{{ $bill->id_proyek }}">
                        <input type="submit" class="btn btn-info btn-block" value="Konfirmasi">
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop