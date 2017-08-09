<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillPenjahit extends Model {

	public $timestamps = false;

    protected $primaryKey = 'id_skill';
    protected $table  = 'tb_skillpenjahit';
    protected $fillable = ['nama_skill', 'id_user'];

	public function tailors(){
        return $this->belongsTo('App\Pengguna','id_user');
    }

}
