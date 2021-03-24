<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    /*
    *is_used :0 not used yet
     *is_used :1 used + not finish
     is_used :2 used + finish
    */
    protected $table = 'coupons';

	public $timestamps = true;
	protected $fillable = array('point_id', 'user_id', 'main', 'remain', 'pull','is_used','expired_at');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
    public function point()
	{
		return $this->belongsTo('App\Models\Point', 'point_id');
	}
}
