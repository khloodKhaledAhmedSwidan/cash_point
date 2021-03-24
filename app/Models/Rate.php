<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model {

	protected $table = 'rates';
	public $timestamps = true;
	protected $fillable = array('user_id', 'store_id', 'description','rate','transaction_id');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function store()
	{
		return $this->belongsTo('App\User', 'store_id');
	}
	public function transaction()
	{
		return $this->belongsTo('App\Models\Transaction', 'transaction_id');
	}

}