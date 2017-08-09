<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model {

    public $timestamps = false;

    protected $primaryKey = 'ids';
    protected $table  = 'tb_images';
    protected $fillable = ['images', 'id_proyek', 'mode_pengukuran'];

	

}
