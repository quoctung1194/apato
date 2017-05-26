<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model {
	use SoftDeletes;
	
	public function users() {
		return $this->hasMany('App\User');
	}
	
	public function blocks() {
		return $this->hasMany('App\Block');
	}
}
