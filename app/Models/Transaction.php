<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {



			/* commission_is_paid :1 store not pay commission yet  
			*commission_is_paid :2 store  pay commission   
			*status : 1 The operation has not been confirmed
			*status : 2 The operation has been confirmed
			*/
	protected $table = 'transactions';
	public $timestamps = true;
	protected $fillable = array('user_id', 'store_id', 'cash', 'point', 'commission', 'order_number','status','commission_is_paid','coupon_id','coupon');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function store()
	{
		return $this->belongsTo('App\User', 'store_id');
	}
	public function coupon()
	{
		return $this->belongsTo('App\Models\Coupon', 'coupon_id');
	}
	public function rates()
	{
		return $this->hasMany('App\Models\Rate', 'transaction_id');
	}
}