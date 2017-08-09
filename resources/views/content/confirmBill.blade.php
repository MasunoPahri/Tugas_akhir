@extends('base')

@section('subtitle') Konfirmasi Pembayaran @stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Konfirmasi Pembayaran </h1>
    </div>
</div>
<br>
<div class="form">
    <form action="/WEB/invoice/sendConfirm" method="post" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="form-group">
            <label class="col-md-2 ">Tipe Pembayaran</label>
            <div class="col-md-6">
                <div class="radio">
                    @if($tipeBayar == "cicilan")
                    <span><label><input type="radio" name="billingType" required value="separate1">Cicilan 1</label></span>
                    <span><label><input type="radio" name="billingType" required value="separate2">Cicilan 2</label></span>
                    @elseif($tipeBayar == "penuh")
                    <span><label><input type="radio" name="billingType" required value="penuh">Bayar Penuh</label></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 ">No. Invoice</label>
            <div class="col-md-6">
                <input type="text" class="form-control" disabled
                    value="{{ $invoice }}">
                 <input type="hidden" class="form-control" name="invoice"
                    value="{{ $invoice }}">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 ">Rekening Pengirim</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="rekfrom" required
                    placeholder="format: Nama_Bank#nama_pemilik#no.rek">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 ">Rekening Penerima</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="rekto" required
                    placeholder="format: Nama_Bank#nama_pemilik#no.rek">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 ">Jumlah Transfer</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="cash" required
                    placeholder="masukkan hanya angka">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-2 ">Bukti Pembayaran</label>
            <div class="col-md-6">
                <input type="file" name="approvalImg" class="form-control">
            </div>
        </div>
        
        <div class="col-md-offset-6">
            <div class="col-md-4">
                <button class="btn btn-info btn-block">Selanjutnya</button>
            </div>
        </div>
    </form>
</div>
@stop
