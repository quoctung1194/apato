<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceReCall extends Model {
	
	protected $fillable = array(
		'service_id', 'user_id'
	);
	
}