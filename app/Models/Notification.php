<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

	protected $table = 'notifications';
	public $timestamps = true;
	protected $fillable = array('user_id', 'store_id', 'title', 'description');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function store()
	{
		return $this->belongsTo('App\User', 'store_id');
	}

}