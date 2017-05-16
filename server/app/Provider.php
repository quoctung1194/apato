<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model {
	use SoftDeletes;
	
	protected $fillable = array(
		'id',
	);
	
}