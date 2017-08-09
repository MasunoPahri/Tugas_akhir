<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model {

    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $table  = 'tb_perbaikan';
    protected $fillable = ['deskripsi', 'foto', 'id_penjahit', 'id_konsumen', 'id_proyek'];

}
