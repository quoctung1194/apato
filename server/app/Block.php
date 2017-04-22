<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model {
	use SoftDeletes;

	public function apartment() {
		return $this->belongsTo('App\Apartment');
	}
	
	public function floors() {
		return $this->hasMany('App\Floor');
	}
}
