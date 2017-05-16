<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model {
	
	protected $fillable = array(
		'id',
	);
	
	public function userServeys() {
		return $this->hasMany('App\UserSurvey');
	}
}