<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomSizeProject extends Model {

    public $timestamps = false;

    protected $primaryKey = 'id_item';
    protected $table  = 'tb_proyek_cstmsize';
    protected $fillable = ['kategori', 'l_badan', 'l_pinggang', 'l_pinggul', 'l_pundak', 'p_lengan', 'p_blazzer', 'deskripsi', 'id_proyek'];

    public function attrProject(){
        return $this->belongsTo('App\Project','id_proyek');
    }    

    public function design(){
        return $this->hasMany('App\Images', 'id_item');
    }

}
