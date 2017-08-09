<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model {

    public $timestamps = false;

    protected $table  = 'tb_usertoken';
    protected $fillable = ['id_user', 'token', 'device'];

}
