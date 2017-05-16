<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderServiceType extends Model {
	use SoftDeletes;
	
	protected $fillable = array(
		'id',
	);
	
}