<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model {


	/*
	*status :2 نشط
	* status : 1 لا يوجد طلب
	*status : 3 اتأكد 
	status : 4 مرفوض 
	*type : 0 : cash النقاط اتحولت كاش   
	*الstatus تبع ال cash معتمده ان النقاط دي اتحولت فلوس كاش 
	*type : 1 النقاط اتحولت قسيمة شراء
	*/
	protected $table = 'points';
	public $timestamps = true;
	protected $fillable = array('user_id', 'main', 'pull', 'remain', 'status','cash','type');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
	public function coupons()
	{
		return $this->hasMany('App\Models\Coupon', 'point_id');
	}

}