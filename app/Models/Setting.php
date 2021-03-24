<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $table = 'settings';
	public $timestamps = true;
	protected $fillable = array('term', 'condition', 'description', 'logo', 'min_limit_replacement', 'client_cash', 'max_commission','scope_of_search',
	'coupon_period',
'twitter',
'instagram',
'facebook',
'phone',
'min_text');

}