<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class StandartSizeProject extends Model {

    public $timestamps = false;
    
    protected $primaryKey = 'id_item';
    protected $table  = 'tb_proyek_stdsize';
    protected $fillable = ['kategori', 'ukuran', 'jlhPakaian', 'deskripsi', 'id_proyek'];

    public function attrProject(){
        return $this->belongsTo('App\Project','id_proyek');
    }    

    public function design(){
        return $this->hasMany('App\Images', 'id_item');
    }

}
