<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model {
	
    public $timestamps = false;

    protected $primaryKey = 'id_user';
    protected $table  = 'tb_pengguna';
    protected $fillable = ['nama_user', 'email', 'password', 'salt', 'alamat', 'no_telp', 'foto', 'peran', 'status_aktif'];

    public function skills(){
        // return $this->hasMany('App\SkillPenjahit', 'id_user');
        return $this->belongsToMany('App\SkillPenjahit', 'tbpivot_skillpenjahit', 'id_user', 'id_skill');
    }

    public function testimoni(){
        return $this->hasMany('App\Testimonial', 'id_penjahit');
    }

    public function portofolio(){
        return $this->hasMany('App\Portofolio', 'id_penjahit');
    }

}
