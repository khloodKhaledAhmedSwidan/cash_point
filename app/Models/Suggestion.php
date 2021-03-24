<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model {

	protected $table = 'suggestions';
	public $timestamps = true;
	protected $fillable = array('description', 'user_id');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

}