<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {

	protected $table = 'sliders';
	public $timestamps = true;
	protected $fillable = array('image', 'user_id', 'admin_id', 'link','category_id');

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function admin()
	{
		return $this->belongsTo('App\Admin', 'admin_id');
	}
	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id');
	}
}