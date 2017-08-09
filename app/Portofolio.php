<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model {

    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table  = 'tb_portofolio';
    protected $fillable = ['deskripsi', 'foto', 'id_penjahit'];


	public function penjahit(){
        return $this->belongsTo('App\Pengguna','id_penjahit');
    }

}
