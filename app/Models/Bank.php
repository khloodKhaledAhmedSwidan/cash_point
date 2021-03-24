<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

	protected $table = 'banks';
	public $timestamps = true;
	protected $fillable = array('name');

	public function users()
	{
		return $this->hasMany('App\User', 'bank_id');
	}

}