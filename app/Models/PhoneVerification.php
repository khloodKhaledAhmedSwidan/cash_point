<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model {

	protected $table = 'phone_verification';
	public $timestamps = true;
	protected $fillable = array('phone', 'code','country_id');
	public function country()
	{
		return $this->belongsTo('App\Models\Country', 'country_id');
	}
}