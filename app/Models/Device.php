<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {

	protected $table = 'devices';
	public $timestamps = true;
	protected $fillable = array('user_id', 'device_token');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

}