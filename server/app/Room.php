<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model {
	use SoftDeletes;

	public function floor() {
		return $this->belongsTo('App\Floor');
	}
}
