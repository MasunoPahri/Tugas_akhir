<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportAbuse extends Model {

	public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table  = 'tb_laporan';
    protected $fillable = ['konten', 'id_penjahit'];

	public function tailors(){
        return $this->belongsTo('App\Pengguna','id_penjahit');
    }

}
