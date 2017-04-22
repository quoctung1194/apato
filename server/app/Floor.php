<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model {
	use SoftDeletes;

	public function block() {
		return $this->belongsTo('App\Block');
	}
	
	public function rooms() {
		return $this->hasMany('App\Room');
	}
}
