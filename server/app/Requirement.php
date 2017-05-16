<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model {

	protected $fillable = array(
		'id',
	);
	
	public function requirementImages() {
		return $this->hasMany('App\RequirementImage');
	}
}