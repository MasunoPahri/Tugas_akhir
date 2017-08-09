<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model {

    public $timestamps = false;

    protected $table  = 'tb_pembayaran';
    protected $fillable = ['invoice_num', 'tipe_bayar', 'rek_pengirim', 'rek_penerima', 'status_konfirmasi', 'bukti', 'id_proyek'];

    public function proyek(){
        return $this->belongsTo('App\Project', 'id_proyek');
    }

}
