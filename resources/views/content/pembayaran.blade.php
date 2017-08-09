@extends('base')

@section('subtitle') Pembayaran @stop

@section('content')
<div class="bidList col-md-12">
    <h3>Daftar Pembayaran</h3>
    <table class="bidlist">
        <thead>
            <tr>
                <th style="width: 40%">Invoice</th>
                <th style="width: 20%">Jumlah Pembayaran</th>
                <th style="width: 20%">Jenis Pembayaran</th>
                <th style="width: 20%">Status</th>
                <th style="width: 10%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $bill_List)
                @if(count($bill_List->bills) != 0)
                    <tr>
                        <td>
                            <b>#{{ $bill_List->bills[0]->invoice_num }} - {{ $bill_List->nama_proyek }}</b><br>
                        </td>
                        
                        <td>
                            Rp. {{ number_format($bill_List->bills[0]->jlh_bayar , 2, ',', '.') }}
                        </td>
                        
                        <td>
                            @if( count($bill_List->bills) > 0 )
                                @if( $bill_List->tipe_bayar == "separate1" )
                                    {{ $bill_List->tipe_bayar }} - cicilan 1
                                @elseif( $bill_List->tipe_bayar == "separate2" )
                                    {{ $bill_List->tipe_bayar }} - cicilan 2
                                @endif
                                {{ $bill_List->tipe_bayar }}
                            @endif
                        </td>
                        
                        <td>
                            @if($bill_List->bills[0]->ket  == "Belum Dibayar")
                            <span class="label label-danger">
                                {{ $bill_List->bills[0]->ket }}
                            </span>
                            @elseif($bill_List->bills[0]->ket == "pending")
                            <span class="label label-warning">
                                {{ $bill_List->bills[0]->ket }}
                            </span>
                            @elseif($bill_List->bills[0]->ket == "lunas")
                            <span class="label label-success">
                                {{ $bill_List->bills[0]->ket }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @if($bill_List->bills[0]->ket == "Belum Dibayar")
                            <a href="/WEB/invoice/confirm/{{$bill_List->id_proyek}}" 
                                class="btn btn-success btn-block">
                                Bayar    
                            </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@stop