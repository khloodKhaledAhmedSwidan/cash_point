<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model {

	protected $table = 'records';
	public $timestamps = true;
	protected $fillable = array('user_id', 'image', 'commission_id', 'status', 'cash', 'paid', 'remain');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function commission()
	{
		return $this->belongsTo('App\Models\Commissions', 'commission_id');
	}

}