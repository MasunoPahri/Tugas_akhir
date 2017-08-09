<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tawaran extends Model {

    public $timestamps = false;

    protected $primaryKey = 'id_tawaran';
    protected $table  = 'tb_tawaran';
    protected $fillable = ['dipilih', 'harga', 'lama_pengerjaan'];
	
    public function tailorsBid(){
        return $this->belongsToMany('App\Project', 'tb_proyektawaran', 'id_tawaran', 'id_proyek');
    }

    public function proyek(){
        return $this->belongsTo('App\Project', 'id_proyek');
    }

    public function penjahit(){
        return $this->belongsTo('App\Pengguna', 'id_penjahit');
    }

}
