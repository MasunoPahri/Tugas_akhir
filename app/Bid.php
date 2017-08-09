<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model {

    public $timestamps = false;

    protected $table  = 'tb_tawaran';
    protected $fillable = ['dipilih', 'harga', 'lama_pengerjaan', 'id_penjahit', 'id_proyek'];

    public function proyek(){
        return $this->belongsTo('App\Project','id_proyek');
    }
    
    public function tailorsBid(){
        return $this->belongsToMany('App\Project', 'tb_proyektawaran', 'id_tawaran', 'id_proyek');
    }
}
