<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Admin extends Model implements	AuthenticatableContract,
										AuthorizableContract,
										CanResetPasswordContract {
	
	use Authenticatable, Authorizable, CanResetPassword;
	
	protected $fillable = array
	(
			'id',
	);
	
	public function apartment() {
		return $this->belongsTo('App\Apartment');
	}
	
} 

