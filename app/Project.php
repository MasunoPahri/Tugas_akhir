<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    public $timestamps = false;

    protected $primaryKey = 'id_proyek';
    protected $table  = 'tb_proyek';
    protected $fillable = ['nama_proyek', 'mode_pengukuran', 'id_user', 'status'];

    public function bid(){
        return $this->hasMany('App\Bid');
    }

    public function customSize(){
        return $this->hasMany('App\CustomSizeProject', 'id_proyek');
    }

    public function stdSize(){
        return $this->hasMany('App\StandartSizeProject', 'id_proyek');
    }

    public function bidListing(){
        return $this->belongsToMany('App\Pengguna', 'tb_tawaran','id_proyek', 'id_penjahit');
    }

    public function userBidsData(){
        return $this->hasManyThrough('App\Pengguna', 'App\Tawaran', 'id_proyek', 'id_user');
    }
    
    public function bills(){
        return $this->hasMany('App\Billing', 'id_proyek');
    }

    public function users(){
        return $this->belongsTo('App\Pengguna', 'id_penjahit');
    }
    
    public function penawar(){
        return $this->hasMany('App\Tawaran', 'id_proyek');
    }
}
