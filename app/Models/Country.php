<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $table = 'countries';
	public $timestamps = true;
	protected $fillable = array('code', 'name', 'image','currency');

	public function users()
	{
		return $this->hasMany('App\User', 'country_id');
	}
}
