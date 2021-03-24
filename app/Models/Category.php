<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';
	public $timestamps = true;
	protected $fillable = array('name', 'image');

	public function users()
	{
		return $this->hasMany('App\User', 'category_id');
	}
	public function sliders()
	{
		return $this->hasMany('App\Models\Slider', 'category_id');
	}
}