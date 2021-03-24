<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //


	/*
	*main : 0  ==> when has points
	*main: 1 ==>default member user has when login
	*/
    protected $table = 'members';
	public $timestamps = true;
	protected $fillable = array('point', 'title','main','type');

	public function users()
	{
		return $this->hasMany('App\User', 'member_id');
	}
}
