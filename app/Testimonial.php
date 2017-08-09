<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model {

    public $timestamps = false;

    protected $primaryKey = 'id_testimoni';
    protected $table  = 'tb_testimonial';
    protected $fillable = ['ratting', 'komentar', 'status_terbit', 'id_penjahit', 'id_konsumen'];

    public function users(){    
        return $this->belongsTo('App\Pengguna', 'id_konsumen');
    }
}
