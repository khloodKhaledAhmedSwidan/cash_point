<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
	public $timestamps = true;
	protected $fillable = array('message', 'user_id');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
    //
}
