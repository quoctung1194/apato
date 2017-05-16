<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
	const PRIVACY_PUBLIC = 0;
	const PRIVACY_PRIVATE = 1;
	
	const TYPE_SURVEY = 1;
	const TYPE_NORMAL = 0;
	
	const CHECK_SINGLE = 1;
	const CHECK_MULTIPLE = 0;
	
	protected $fillable = array
	(
		'id',
	);
	
	public function surveyOptions() {
		return $this->hasMany('App\SurveyOption');
	}
}
