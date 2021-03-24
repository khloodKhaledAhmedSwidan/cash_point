<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use Notifiable;
	// use SoftDeletingTrait;
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */




	 /**
	  *  type  : 1 => client
	  *  type :  2 => store 
	  *logo :شعار المتجر
	  * صورة السجل التجاري :trade_register
	  * ملف العقد pdf : file
	  */
	protected $fillable = array(
		'phone', 
	    'password',
	    'name', 
		'bank_id', 
		'type', 
		'category_id',
		'active',
		'api_token',
		'remember_token',
		'language',
		'description',
		'latitude',
		'longitude',
	    'membership_num', 
		 'commission',
		 'logo',
		 'file',
		 'arranging',
        'last_login_at', 
	    'last_login_ip', 
		'trade_register', 
		 'bank_account',
		'point_equal_SR',
		 'country_id',
		 'verification_code',
		'image',
		'member_id',
		'coupon'
		);


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function bank()
	{
		return $this->belongsTo('App\Models\Bank', 'bank_id');
	}
	public function coupons()
	{
		return $this->hasMany('App\Models\Coupon', 'user_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}
	public function country()
	{
		return $this->belongsTo('App\Models\Country', 'country_id');
	}
	public function member()
	{
		return $this->belongsTo('App\Models\Member', 'member_id');
	}
	public function records()
	{
		return $this->hasMany('App\Models\Record', 'user_id');
	}

	public function contacts()
	{
		return $this->hasMany('App\Models\Contact', 'user_id');
	}
	public function suggestions()
	{
		return $this->hasMany('App\Models\Suggestion', 'user_id');
	}

	public function points()
	{
		return $this->hasMany('App\Models\Point', 'user_id');
	}

	public function notifications()
	{
		return $this->hasMany('App\Models\Notification', 'user_id');
	}

	public function storeNotifications()
	{
		return $this->hasMany('App\Models\Notification', 'store_id');
	}

	public function transactions()
	{
		return $this->hasMany('App\Models\Transaction', 'user_id');
	}

	public function storeTransactions()
	{
		return $this->hasMany('App\Models\Transaction', 'store_id');
	}

	public function rates()
	{
		return $this->hasMany('App\Models\Rate', 'user_id');
	}

	public function storeRates()
	{
		return $this->hasMany('App\Models\Rate', 'store_id');
	}

	public function sliders()
	{
		return $this->hasMany('App\Models\Slider', 'user_id');
	}

	public function device()
	{
		return $this->hasOne('App\Models\Device', 'user_id');
	}
}
