<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commissions extends Model {

	/*
	*status => 0 لم يتم تأكيد الدفع بعد
	*status => 1 تم تأكيد الدفع
	*/
	protected $table = 'commissions';
	public $timestamps = true;
	protected $fillable = array('user_id', 'total', 'paid', 'remain', 'image', 'invoice', 'status', 'coupon','coupon_id');

	public function records()
	{
		return $this->hasMany('App\Models\Record', 'commission_id');
	}
	public function coupon()
	{
		return $this->belongsTo('App\Models\Coupon', 'coupon_id');
	}

}